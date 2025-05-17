<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $search = $request->input('search');

        // if ($search) {
        //     $users = User::where(function ($query) use ($search) {
        //             $query->where('name', 'like', '%' . $search . '%')
        //                   ->orWhere('email', 'like', '%' . $search . '%');
        //         })
        //         ->where('id', '!=', '1')
        //         ->orderBy('name')
        //         ->paginate(20)
        //         ->withQueryString();
        // } else {
        //     $users = User::where('id', '!=', '1')
        //         ->orderBy('name')
        //         ->paginate(10);
        // }

        // return view('user.index', compact('users'));
        $search = request('search');
        if ($search) {
            $users = User::with('todos')->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        } else {
            $users = User::with('todos')->where('id', '!=', 1)
                        ->orderBy('name')
                        ->paginate(10);
        }

        return view('user.index', compact('users'));

    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();
        return back()->with('success', 'Remove admin successfully');
    }

    public function removeadmin(User $user)
    {
        if ($user->id != 1){
            $user->timestamps =false;
            $user->is_admin = false;
            $user->save();
            return back()->with('success', 'Make admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1) {
            $user->delete();
            return back()->with('success', 'Delete user successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Delete user failed!');
        }
    }
    

//     public function edit()
//     {
//         return view('user.edit');
//     }

}
