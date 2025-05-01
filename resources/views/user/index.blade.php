<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg px-4 py-6">
                <div class="px-6 pt-6 mb-5 w-full sm:w-2/3 md:w-1/2 lg:w-1/3">
                    @if (request('search'))
                        <h2 class="pb-3 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            Search results for: <strong>{{ request('search') }}</strong>
                        </h2>
                    @endif

                    <form class="flex items-center gap-3">
                        <x-text-input 
                            id="search" 
                            name="search" 
                            type="text" 
                            class="w-5/6" 
                            placeholder="Search by name or email ..." 
                            value="{{ request('search') }}" 
                            autofocus 
                        />
                        <x-primary-button type="submit">
                            {{ __('Search') }}
                        </x-primary-button>
                    </form>
                </div>

                <div class="px-6 text-xl text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <div></div>

                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 5000)"
                               class="pb-3 text-sm text-green-600 dark:text-green-400">
                                {{ session('success') }}
                            </p>
                        @endif

                        @if (session('danger'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 5000)"
                               class="pb-3 text-sm text-red-600 dark:text-red-400">
                                {{ session('danger') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="relative overflow-x-auto flex justify-center">
                    <table class="w-full max-w-4xl text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4">Id</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Todo</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                    <td class="px-6 py-4 font-medium dark:text-gray-100">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-3 py-1 font-medium dark:text-gray-100">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-3 py-1 dark:text-gray-100">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-3 py-1 whitespace-nowrap dark:text-gray-100">
                                        {{ $user->todos->count() }}
                                        <span class="text-green-500 ml-1">
                                            ({{ $user->todos->where('is_done', true)->count() }})
                                        </span>
                                        <span class="text-blue-500 ml-1">
                                            ({{ $user->todos->where('is_done', false)->count() }})
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
            <div class="flex space-x-3">
                @if ($user->is_admin)
                    <form action="{{ route('user.removeadmin', $user) }}" method="Post">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="text-blue-600 dark:text-blue-400 whitespace-nowrap">
                            Remove Admin
                        </button>
                    </form>
                @else
                    <form action="{{ route('user.makeadmin', $user) }}" method="Post">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="text-red-600 dark:text-red-400 whitespace-nowrap">
                            Make Admin
                        </button>
                    </form>
                @endif
            </div>
            <form action="{{ route('user.destroy', $user) }}" method="Post">
    @csrf
    @method('delete')
    <button type="submit"
        class="text-red-600 dark:text-red-400 whitespace-nowrap">
        Delete
    </button>
</form>

        </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-gray-800">
                                    <td colspan="5" class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="p-6 flex justify-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
