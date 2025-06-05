<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('api')->user();
        if (!$user || !$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
