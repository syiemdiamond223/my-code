@extends('layouts.admin')

@section('page-title', 'Manage Users')

@section('page-subtitle', 'View and manage all registered users')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-purple-900 mb-6">
            Manage Users
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse text-gray-800">

                <thead>
                    <tr class="bg-purple-100 text-left border-b border-purple-200">
                        <th class="p-4 font-bold text-purple-900">ID</th>
                        <th class="p-4 font-bold text-purple-900">Name</th>
                        <th class="p-4 font-bold text-purple-900">Email</th>
                        <th class="p-4 font-bold text-purple-900">Role</th>
                        <th class="p-4 font-bold text-purple-900">Status</th>
                        <th class="p-4 font-bold text-purple-900">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr class="border-b hover:bg-purple-50 transition">

                            <!-- ID -->
                            <td class="p-4 text-gray-900 font-medium">
                                {{ $user->id }}
                            </td>

                            <!-- NAME -->
                            <td class="p-4 text-gray-900 font-medium">
                                {{ $user->name }}
                            </td>

                            <!-- EMAIL -->
                            <td class="p-4 text-gray-700">
                                {{ $user->email }}
                            </td>

                            <!-- ROLE -->
                            <td class="p-4 text-gray-700">
                                {{ ucfirst($user->role) }}
                            </td>

                            <!-- STATUS -->
                            <td class="p-4">

                                @if($user->status == 'blocked')

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Blocked
                                    </span>

                                @else

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Active
                                    </span>

                                @endif

                            </td>

                            <!-- ACTION -->
                            <td class="p-4">

                                @if($user->role === 'admin')

                                    <span class="text-gray-500 text-sm font-semibold">
                                        Protected
                                    </span>

                                @else

                                    <form method="POST"
                                          action="{{ route('admin.users.toggle', $user->id) }}">

                                        @csrf
                                        @method('PATCH')

                                        @if($user->status == 'blocked')

                                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                                Unblock
                                            </button>

                                        @else

                                            <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                                Block
                                            </button>

                                        @endif

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection