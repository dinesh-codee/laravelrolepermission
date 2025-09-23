<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles / Create
            </h2>
            <a href="{{ route('articles.index') }}"
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
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf
                        <div>
                            <div class="mb-3">
                                {{-- Title Section --}}
                                <label for="title" class="text-lg font-medium">Title</label>
                                <div class="my-3">
                                    <input value="{{ old('title') }}" type="text" name="title"
                                        class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Title">
                                    @error('title')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Content Section --}}
                                <label for="content" class="text-lg font-medium">Content</label>
                                <div class="my-3">
                                    <textarea name="text" id="text" placeholder="Content Area" class="border-gray-300 shadow-sm w-1/2 rounded-lg" cols="30"
                                        rows="10">{{ old('text') }}</textarea>
                                </div>

                                {{-- Author Section --}}
                                <label for="author" class="text-lg font-medium">Author</label>
                                <div class="my-3">
                                    <input value="{{ old('author') }}" type="text" name="author"
                                        class="border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Author">
                                    @error('author')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
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
