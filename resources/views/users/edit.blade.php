@can('edit users')

    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Users / Edit
                </h2>
                <a href="{{ route('users.index') }}" class="bg-blue-600 text-sm rounded-md px-3 py-2 text-white ">Back</a>
            </div>
            {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Premission') }}
        </h2> --}}
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            <div>
                                <div class="mb-3">

                                    <label for="name" class="text-lg font-medium">Name</label>
                                    {{-- Users name --}}
                                    <div class="my-3">
                                        <input value="{{ old('name', $user->name) }}" type="text" name="name"
                                            class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Enter user">
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <label for="email" class="text-lg font-medium">Email</label>
                                    {{-- Users email --}}
                                    <div class="my-3">
                                        <input value="{{ old('email', $user->email) }}" type="text" name="email"
                                            class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Email Here">
                                        @error('email')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-4 mb-3">
                                        @if ($roles->isNotEmpty())
                                            @foreach ($roles as $role)
                                                <div class="mt-3">
                                                    <div>
                                                        {{-- --}}
                                                        <input {{ $hasRole->contains($role->id) ? 'checked' : '' }}
                                                            type="checkbox" id="role-{{ $role->id }}" class="rounded"
                                                            name="role[]" value="{{ $role->name }}">
                                                        <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button
                                        class="bg-blue-700 hover:bg-blue-600 text-sm rounded-md px-5 py-3 text-white ">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endcan
