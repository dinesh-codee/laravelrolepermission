<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles / Create
            </h2>
            <a href="{{ route('permissions.index') }}"
                class="bg-blue-600 text-sm rounded-md px-3 py-2 text-white ">Back</a>
        </div>
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Premission') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div>
                            <div class="mb-3">
                                <label for="name" class="text-lg font-medium">Name</label>
                                <div class="my-3">
                                    <input value="{{ old('name') }}" type="text" name="name"
                                        class="border-gray-300 shadow-sm w-1/2 rounded-lg"
                                        placeholder="Enter Permission">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-4 mb-3">
                                    @if ($permissions->isNotEmpty())
                                        @foreach ($permissions as $permission)
                                            <div class="mt-3">
                                                <div>
                                                    <input type="checkbox" id="permission-{{ $permission->id }}" class="rounded" name="permission[]" value="{{ $permission->name }}">
                                                    <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach

                                    @endif
                                </div>
                                <button class="bg-blue-700 text-sm rounded-md px-5 py-3 text-white ">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
