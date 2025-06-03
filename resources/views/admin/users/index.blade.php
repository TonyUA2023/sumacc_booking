{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Users - SUMACC Admin')
@section('page-title', 'Users Management')

@section('content')
<div x-data="usersPageData()" x-init="initPage()" class="space-y-6">
    {{-- Encabezado con botón “Create New User” --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                <h3 class="text-lg font-medium text-gray-700">All Users</h3>
                <div class="mt-3 sm:mt-0">
                    <button
                        @click="showCreateModal = true"
                        type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                  clip-rule="evenodd" />
                        </svg>
                        Create New User
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabla de usuarios --}}
        <div class="overflow-x-auto">
            @if($users->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Created At</th>
                            <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $user->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->created_at->format('Y-m-d') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <button
                                        @click="viewUser(@js($user))"
                                        type="button"
                                        class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none"
                                    >
                                        View
                                    </button>
                                    <button
                                        @click="editUser(@js($user))"
                                        class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="openDeleteModal(@js($user))"
                                        class="ml-4 text-red-600 hover:text-red-800 hover:underline focus:outline-none"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no users to display. You can create one now.</p>
                    <div class="mt-6">
                        <button
                            @click="showCreateModal = true"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                      clip-rule="evenodd" />
                            </svg>
                            Create New User
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Create New User --}}
    {{-- ================================================= --}}
    <div
        x-show="showCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-create-user"
        role="dialog"
        aria-modal="true"
        x-cloak
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Fondo semitransparente --}}
            <div
                x-show="showCreateModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                aria-hidden="true"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showCreateModal"
                @click.outside="showCreateModal = false"
                x-transition
                class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create-user">
                        Create New User
                    </h3>
                    <button
                        @click="showCreateModal = false"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="_form_type" value="create_user">

                    {{-- Name --}}
                    <div>
                        <label for="create_user_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="create_user_name"
                            value="{{ old('name') }}"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="create_user_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="create_user_email"
                            value="{{ old('email') }}"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="create_user_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="create_user_password"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label for="create_user_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="create_user_password_confirmation"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                    </div>

                    {{-- Botones Cancel / Create --}}
                    <div class="pt-6 mt-8 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button
                                @click="showCreateModal = false"
                                type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                            >
                                Create User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: View User Details --}}
    {{-- ================================================= --}}
    <div
        x-show="showViewModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-view-user"
        role="dialog"
        aria-modal="true"
        x-cloak
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Fondo semitransparente --}}
            <div
                x-show="showViewModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                aria-hidden="true"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showViewModal"
                @click.outside="showViewModal = false; userToView = null"
                x-transition
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-view-user">
                        User Details: <span class="font-bold" x-text="userToView ? userToView.name : ''"></span>
                    </h3>
                    <button
                        @click="showViewModal = false; userToView = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="userToView">
                    <div class="space-y-4 mt-4">
                        <p><strong>ID:</strong> <span x-text="userToView.id"></span></p>
                        <p><strong>Name:</strong> <span x-text="userToView.name"></span></p>
                        <p><strong>Email:</strong> <span x-text="userToView.email"></span></p>
                        <p><strong>Joined:</strong> <span x-text="new Date(userToView.created_at).toLocaleDateString()"></span></p>
                    </div>
                </template>

                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showViewModal = false; userToView = null"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        >
                            Close
                        </button>
                        <button
                            @click="editUser(userToView); showViewModal = false"
                            type="button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                        >
                            Edit User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Edit User --}}
    {{-- ================================================= --}}
    <div
        x-show="showEditModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        x-cloak
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Fondo semitransparente --}}
            <div
                x-show="showEditModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showEditModal"
                @click.outside="showEditModal = false; userToEdit = null"
                x-transition
                class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit User&nbsp;<span class="font-semibold" x-text="userToEdit ? userToEdit.id : ''"></span>
                    </h3>
                    <button
                        @click="showEditModal = false; userToEdit = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="userToEdit">
                    <form
                        :action="`/admin/users/${userToEdit.id}`"
                        method="POST"
                        class="mt-6 space-y-6"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form_type" value="edit_user">

                        {{-- Name --}}
                        <div>
                            <label for="edit_user_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input
                                type="text"
                                name="name"
                                id="edit_user_name"
                                x-model="userToEdit.name"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            <template x-if="$store.errorBag?.errors?.['name']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['name'][0]"></p>
                            </template>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="edit_user_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="edit_user_email"
                                x-model="userToEdit.email"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            <template x-if="$store.errorBag?.errors?.['email']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['email'][0]"></p>
                            </template>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="edit_user_password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                            <input
                                type="password"
                                name="password"
                                id="edit_user_password"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            <template x-if="$store.errorBag?.errors?.['password']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['password'][0]"></p>
                            </template>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="edit_user_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="edit_user_password_confirmation"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                        </div>

                        {{-- Botones Cancel / Save --}}
                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button
                                    @click="showEditModal = false; userToEdit = null"
                                    type="button"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Delete User Confirmation --}}
    {{-- ================================================= --}}
    <div
        x-show="showDeleteModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        x-cloak
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Fondo semitransparente --}}
            <div
                x-show="showDeleteModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showDeleteModal"
                @click.outside="showDeleteModal = false; userIdToDelete = null; userNameToDelete = ''"
                x-transition
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle"
            >
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium text-gray-900">Delete User</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete user
                                "<strong x-text="userNameToDelete"></strong>"?
                                This cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form
                        :action="`/admin/users/${userIdToDelete}`"
                        method="POST"
                        class="inline-block"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            :disabled="!userIdToDelete"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </form>
                    <button
                        @click="showDeleteModal = false; userIdToDelete = null; userNameToDelete = ''"
                        type="button"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Data y Métodos para Users --}}
<script>
    function usersPageData() {
        return {
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create_user') ? 'true' : 'false' }},
            showViewModal: false,
            showEditModal: {{ ($errors->any() && old('_form_type') === 'edit_user') ? 'true' : 'false' }},
            showDeleteModal: false,

            userToView: null,
            userToEdit: null,
            userIdToDelete: null,
            userNameToDelete: '',

            initPage() {
                @if($errors->any() && old('_form_type') === 'edit_user' && old('user_id_for_edit_error'))
                    let editId = {{ old('user_id_for_edit_error') }};
                    let existingUser = @js($users->map->only(['id','name','email','created_at']))
                                       .find(u => u.id === editId);
                    if (existingUser) {
                        this.editUser(existingUser, true);
                    }
                @endif
            },

            viewUser(user) {
                if (!user) return;
                this.userToView = JSON.parse(JSON.stringify(user));
                this.showViewModal = true;
            },

            editUser(user, openModal = true) {
                if (!user) return;
                this.userToEdit = JSON.parse(JSON.stringify(user));
                if (openModal) {
                    this.showEditModal = true;
                }
            },

            openDeleteModal(user) {
                if (!user) return;
                this.userIdToDelete = user.id;
                this.userNameToDelete = user.name;
                this.showDeleteModal = true;
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('usersPageData', usersPageData);
    });
</script>
@endsection