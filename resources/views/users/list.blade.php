<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>

            @can('create users')
            <a href="{{ route('roles.create') }}" class="bg-blue-600 text-sm rounded-md px-3 py-2 text-white ">Create</a>
            @endcan
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-message></x-message>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">#</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Roles</th>
                                <th class="px-6 py-3 text-left" width="180">Created</th>
                                <th class="px-6 py-3 text-center" width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @if ($users->isNotempty())
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-3 text-left">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-3 text-left">{{ $user->name }}</td>
                                        <td class="px-6 py-3 text-left">{{ $user->email }}</td>
                                        <td class="px-6 py-3 text-left">{{ $user->roles->pluck('name')->implode(', ') }}
                                        </td>
                                        <td class="px-6 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                                        <td class="px-6 py-3 text-center">

                                            @can('edit users')
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="bg-slate-700 hover:bg-slate-500 text-sm rounded-md px-3 py-2 text-white ">Edit</a>
                                            @endcan

                                            {{-- @can('delete users')
                                                <a href="javascript:void(0)" onclick="deleteRole({{ $user->id }})"
                                                    class="bg-red-700 hover:bg-red-500 text-sm rounded-md px-3 py-2 text-white ">Delete</a>
                                            @endcan --}}

                                            {{-- <a href="javascript:void(0)" onclick="deleteuser({{ $user->id }})"
                                                class="bg-red-700 hover:bg-red-500 text-sm rounded-md px-3 py-2 text-white ">Delete</a> --}}

                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>

                    <div class="my-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id) {
                if (confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: '{{ route('roles.destroy') }}',
                        type: 'delete',
                        data: {
                            id
                        },
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },

                        success: function(response) {
                            window.location.href = "{{ route('roles.index') }}";
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>
