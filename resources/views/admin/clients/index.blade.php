{{-- resources/views/admin/clients/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Clients - SUMACC Admin')
@section('page-title', 'Clients Management')

@section('content')
<div x-data="clientsPageData()" x-init="initPage()" class="space-y-6">
    {{-- Encabezado con botón Create --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                <h3 class="text-lg font-medium text-gray-700">All Clients</h3>
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
                        Create New Client
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabla de clientes --}}
        <div class="overflow-x-auto">
            @if($clients->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">Addresses</th>
                            <th class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">Appointments</th>
                            <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($clients as $client)
                            @php
                                $clientDataForModal = $client->loadMissing(['addresses', 'appointments']);
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $client->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $client->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $client->phone ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    {{ $client->addresses_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">
                                    {{ $client->appointments_count }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <button
                                        @click="viewClient(@js($clientDataForModal))"
                                        type="button"
                                        class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none"
                                    >
                                        View
                                    </button>
                                    <button
                                        @click="editClient(@js($clientDataForModal))"
                                        type="button"
                                        class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="openDeleteModal(@js($clientDataForModal))"
                                        type="button"
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
                    {{ $clients->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 17C17 14.2386 14.7614 12 12 12C9.23858 12 7 14.2386 7 17C7 17.5523 7.44772 18 8 18H16C16.5523 18 17 17.5523 17 17ZM12 2C14.7614 2 17 4.23858 17 7C17 9.76142 14.7614 12 12 12C9.23858 12 7 9.76142 7 7C7 4.23858 9.23858 2 12 2Z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No clients found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no clients to display. You can create one now.</p>
                    <div class="mt-6">
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
                            Create New Client
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Create New Client --}}
    {{-- ================================================= --}}
    <div
        x-show="showCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-create-client"
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
                class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create-client">
                        Create New Client
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

                <form action="{{ route('admin.clients.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="_form_type" value="create_client">

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        {{-- First Name --}}
                        <div class="sm:col-span-1">
                            <label for="create_client_first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input
                                type="text"
                                name="first_name"
                                id="create_client_first_name"
                                value="{{ old('first_name') }}"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            @error('first_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="sm:col-span-1">
                            <label for="create_client_last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input
                                type="text"
                                name="last_name"
                                id="create_client_last_name"
                                value="{{ old('last_name') }}"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            @error('last_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-2">
                            <label for="create_client_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="create_client_email"
                                value="{{ old('email') }}"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="sm:col-span-2">
                            <label for="create_client_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input
                                type="tel"
                                name="phone"
                                id="create_client_phone"
                                value="{{ old('phone') }}"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            @error('phone')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 mt-4 border-t">
                        <h4 class="text-md font-medium text-gray-800 mb-2">Primary Address (Optional)</h4>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            {{-- Street --}}
                            <div class="sm:col-span-2">
                                <label for="create_address_street" class="block text-sm font-medium text-gray-700">Street</label>
                                <input
                                    type="text"
                                    name="address_street"
                                    id="create_address_street"
                                    value="{{ old('address_street') }}"
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                @error('address_street')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div class="sm:col-span-1">
                                <label for="create_address_city" class="block text-sm font-medium text-gray-700">City</label>
                                <input
                                    type="text"
                                    name="address_city"
                                    id="create_address_city"
                                    value="{{ old('address_city') }}"
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                @error('address_city')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- State --}}
                            <div class="sm:col-span-1">
                                <label for="create_address_state" class="block text-sm font-medium text-gray-700">State</label>
                                <input
                                    type="text"
                                    name="address_state"
                                    id="create_address_state"
                                    value="{{ old('address_state') }}"
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                @error('address_state')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Postal Code --}}
                            <div class="sm:col-span-1">
                                <label for="create_address_postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input
                                    type="text"
                                    name="address_postal_code"
                                    id="create_address_postal_code"
                                    value="{{ old('address_postal_code') }}"
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                @error('address_postal_code')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

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
                                Create Client
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: View Client Details --}}
    {{-- ================================================= --}}
    <div
        x-show="showViewModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-view-client"
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
                @click.outside="showViewModal = false; clientToView = null"
                x-transition
                class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-view-client">
                        Client Details: <span class="font-bold" x-text="clientToView ? clientToView.first_name + ' ' + clientToView.last_name : ''"></span>
                    </h3>
                    <button
                        @click="showViewModal = false; clientToView = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="clientToView">
                    <div class="space-y-6">
                        {{-- Información general --}}
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <p><strong>ID:</strong> #<span x-text="clientToView.id"></span></p>
                            <p><strong>Email:</strong> <span x-text="clientToView.email"></span></p>
                            <p><strong>Phone:</strong> <span x-text="clientToView.phone || 'N/A'"></span></p>
                        </div>

                        {{-- Direcciones --}}
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-2 text-lg font-medium text-gray-800">Addresses</h4>
                            <div x-show="clientToView.addresses && clientToView.addresses.length > 0">
                                <ul class="pl-5 list-disc">
                                    <template x-for="address in clientToView.addresses" :key="address.id">
                                        <li class="text-sm text-gray-700">
                                            <span x-text="`${address.street}, ${address.city}`"></span>
                                            <template x-if="address.state">
                                                <span x-text="`, ${address.state}`"></span>
                                            </template>
                                            <template x-if="address.postal_code">
                                                <span x-text="` ${address.postal_code}`"></span>
                                            </template>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            <div x-show="!clientToView.addresses || clientToView.addresses.length === 0">
                                <p class="text-sm text-gray-500">No addresses on file.</p>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showViewModal = false; clientToView = null"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        >
                            Close
                        </button>
                        <button
                            @click="editClient(clientToView); showViewModal = false"
                            type="button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                        >
                            Edit Client
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Edit Client --}}
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
                @click.outside="showEditModal = false; clientToEdit = null"
                x-transition
                class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit Client&nbsp;<span class="font-semibold" x-text="clientToEdit ? clientToEdit.id : ''"></span>
                    </h3>
                    <button
                        @click="showEditModal = false; clientToEdit = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="clientToEdit">
                    <form
                        :action="`/admin/clients/${clientToEdit.id}`"
                        method="POST"
                        class="mt-6 space-y-6"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form_type" value="edit_client">

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            {{-- First Name --}}
                            <div class="sm:col-span-1">
                                <label for="edit_client_first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input
                                    type="text"
                                    name="first_name"
                                    id="edit_client_first_name"
                                    x-model="clientToEdit.first_name"
                                    required
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                <template x-if="$store.errorBag?.errors?.['first_name']">
                                    <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['first_name'][0]"></p>
                                </template>
                            </div>

                            {{-- Last Name --}}
                            <div class="sm:col-span-1">
                                <label for="edit_client_last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input
                                    type="text"
                                    name="last_name"
                                    id="edit_client_last_name"
                                    x-model="clientToEdit.last_name"
                                    required
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                <template x-if="$store.errorBag?.errors?.['last_name']">
                                    <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['last_name'][0]"></p>
                                </template>
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-2">
                                <label for="edit_client_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="edit_client_email"
                                    x-model="clientToEdit.email"
                                    required
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                <template x-if="$store.errorBag?.errors?.['email']">
                                    <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['email'][0]"></p>
                                </template>
                            </div>

                            {{-- Phone --}}
                            <div class="sm:col-span-2">
                                <label for="edit_client_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    id="edit_client_phone"
                                    x-model="clientToEdit.phone"
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                <template x-if="$store.errorBag?.errors?.['phone']">
                                    <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['phone'][0]"></p>
                                </template>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t">
                            <h4 class="text-md font-medium text-gray-800 mb-2">Primary Address (Optional)</h4>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                {{-- Street --}}
                                <div class="sm:col-span-2">
                                    <label for="edit_address_street" class="block text-sm font-medium text-gray-700">Street</label>
                                    <input
                                        type="text"
                                        name="address_street"
                                        id="edit_address_street"
                                        x-model="clientToEdit.addresses && clientToEdit.addresses.length > 0 ? clientToEdit.addresses[0].street : ''"
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                    <template x-if="$store.errorBag?.errors?.['address_street']">
                                        <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['address_street'][0]"></p>
                                    </template>
                                </div>

                                {{-- City --}}
                                <div class="sm:col-span-1">
                                    <label for="edit_address_city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input
                                        type="text"
                                        name="address_city"
                                        id="edit_address_city"
                                        x-model="clientToEdit.addresses && clientToEdit.addresses.length > 0 ? clientToEdit.addresses[0].city : ''"
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                    <template x-if="$store.errorBag?.errors?.['address_city']">
                                        <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['address_city'][0]"></p>
                                    </template>
                                </div>

                                {{-- State --}}
                                <div class="sm:col-span-1">
                                    <label for="edit_address_state" class="block text-sm font-medium text-gray-700">State</label>
                                    <input
                                        type="text"
                                        name="address_state"
                                        id="edit_address_state"
                                        x-model="clientToEdit.addresses && clientToEdit.addresses.length > 0 ? clientToEdit.addresses[0].state : ''"
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                    <template x-if="$store.errorBag?.errors?.['address_state']">
                                        <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['address_state'][0]"></p>
                                    </template>
                                </div>

                                {{-- Postal Code --}}
                                <div class="sm:col-span-1">
                                    <label for="edit_address_postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input
                                        type="text"
                                        name="address_postal_code"
                                        id="edit_address_postal_code"
                                        x-model="clientToEdit.addresses && clientToEdit.addresses.length > 0 ? clientToEdit.addresses[0].postal_code : ''"
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    >
                                    <template x-if="$store.errorBag?.errors?.['address_postal_code']">
                                        <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['address_postal_code'][0]"></p>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button
                                    @click="showEditModal = false; clientToEdit = null"
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
    {{-- MODAL: Delete Client Confirmation --}}
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
                @click.outside="showDeleteModal = false; clientIdToDelete = null; clientNameToDelete = ''"
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
                        <h3 class="text-lg font-medium text-gray-900">Delete Client</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete client
                                "<strong x-text="clientNameToDelete"></strong>"?
                                This action will remove all their addresses; any pending appointments may also be affected.
                                <br> This cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form
                        :action="`/admin/clients/${clientIdToDelete}`"
                        method="POST"
                        class="inline-block"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            :disabled="!clientIdToDelete"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </form>
                    <button
                        @click="showDeleteModal = false; clientIdToDelete = null; clientNameToDelete = ''"
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

{{-- Alpine.js Data y Métodos para Clients --}}
<script>
    function clientsPageData() {
        return {
            // Modales
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create_client') ? 'true' : 'false' }},
            showEditModal: {{ ($errors->any() && old('_form_type') === 'edit_client') ? 'true' : 'false' }},
            showViewModal: false,
            showDeleteModal: false,

            // Objetos dinámicos
            clientToView: null,
            clientToEdit: null,
            clientIdToDelete: null,
            clientNameToDelete: '',

            initPage() {
                // Si hubo error de validación en edición, reconstruir clientToEdit
                @if($errors->any() && old('_form_type') === 'edit_client' && old('service_id_for_edit_error'))
                    let editId = {{ old('service_id_for_edit_error') }};
                    let existingClient = @js($clients->map->only([
                        'id','first_name','last_name','email','phone','addresses'
                    ]))
                    .find(c => c.id === editId);
                    if (existingClient) {
                        this.editClient(existingClient, true);
                    }
                @endif
            },

            viewClient(clientData) {
                if (!clientData) return;
                this.clientToView = JSON.parse(JSON.stringify(clientData));
                this.showViewModal = true;
            },

            editClient(clientData, openModal = true) {
                if (!clientData) return;
                let clone = JSON.parse(JSON.stringify(clientData));

                // Asegurar que 'addresses' exista en array
                if (!clone.addresses) {
                    clone.addresses = [];
                }

                this.clientToEdit = clone;
                if (openModal) {
                    this.showEditModal = true;
                }
            },

            openDeleteModal(clientData) {
                if (!clientData) return;
                this.clientIdToDelete = clientData.id;
                this.clientNameToDelete = `${clientData.first_name} ${clientData.last_name}`;
                this.showDeleteModal = true;
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('clientsPageData', clientsPageData);
    });
</script>
@endsection