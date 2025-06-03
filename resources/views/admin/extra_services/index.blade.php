{{-- resources/views/admin/extra_services/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Extra Services - SUMACC Admin')
@section('page-title', 'Extra Services Management')

@section('content')
<div x-data="extraServicesPageData()" x-init="initPage()" class="space-y-6">
    {{-- Encabezado con botón “Create New Extra Service” --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                <h3 class="text-lg font-medium text-gray-700">All Extra Services</h3>
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
                        Create New Extra Service
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabla de Extra Services --}}
        <div class="overflow-x-auto">
            @if($extraServices->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($extraServices as $es)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $es->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $es->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($es->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Illuminate\Support\Str::limit($es->description, 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <button
                                        @click="viewExtraService(@js($es))"
                                        type="button"
                                        class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none"
                                    >
                                        View
                                    </button>
                                    <button
                                        @click="editExtraService(@js($es))"
                                        class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="openDeleteModal(@js($es))"
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
                    {{ $extraServices->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No extra services found</h3>
                    <p class="mt-1 text-sm text-gray-500">You can create one now.</p>
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
                            Create New Extra Service
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- =============================== --}}
    {{-- MODAL: Create Extra Service    --}}
    {{-- =============================== --}}
    <div
        x-show="showCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-create-extra-service"
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
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
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
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create-extra-service">
                        Create New Extra Service
                    </h3>
                    <button
                        @click="showCreateModal = false"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.extra-services.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="_form_type" value="create_extra_service">

                    {{-- Name --}}
                    <div>
                        <label for="create_es_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="create_es_name"
                            value="{{ old('name') }}"
                            required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label for="create_es_price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                        <input
                            type="number"
                            name="price"
                            id="create_es_price"
                            value="{{ old('price') }}"
                            step="0.01"
                            min="0"
                            required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('price')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="create_es_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            name="description"
                            id="create_es_description"
                            rows="3"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
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
                                Create Extra Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =============================== --}}
    {{-- MODAL: View Extra Service      --}}
    {{-- =============================== --}}
    <div
        x-show="showViewModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-view-extra-service"
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
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showViewModal"
                @click.outside="showViewModal = false; extraServiceToView = null"
                x-transition
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-view-extra-service">
                        Extra Service Details: <span x-text="extraServiceToView ? extraServiceToView.name : ''"></span>
                    </h3>
                    <button
                        @click="showViewModal = false; extraServiceToView = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="extraServiceToView">
                    <div class="space-y-4 mt-4">
                        <p><strong>ID:</strong> <span x-text="extraServiceToView.id"></span></p>
                        <p><strong>Name:</strong> <span x-text="extraServiceToView.name"></span></p>
                        <p><strong>Price:</strong> $<span x-text="parseFloat(extraServiceToView.price).toFixed(2)"></span></p>
                        <p><strong>Description:</strong></p>
                        <p class="text-gray-700" x-text="extraServiceToView.description || 'No description provided.'"></p>
                    </div>
                </template>

                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showViewModal = false; extraServiceToView = null"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        >
                            Close
                        </button>
                        <button
                            @click="editExtraService(extraServiceToView); showViewModal = false"
                            type="button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                        >
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =============================== --}}
    {{-- MODAL: Edit Extra Service      --}}
    {{-- =============================== --}}
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
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showEditModal"
                @click.outside="showEditModal = false; extraServiceToEdit = null"
                x-transition
                class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit Extra Service&nbsp;<span class="font-semibold" x-text="extraServiceToEdit ? '#' + extraServiceToEdit.id : ''"></span>
                    </h3>
                    <button
                        @click="showEditModal = false; extraServiceToEdit = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="extraServiceToEdit">
                    <form
                        :action="`/admin/extra-services/${extraServiceToEdit.id}`"
                        method="POST"
                        class="mt-6 space-y-6"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form_type" value="edit_extra_service">
                        <input type="hidden" name="extra_service_id_for_edit_error" :value="extraServiceToEdit.id">

                        {{-- Name --}}
                        <div>
                            <label for="edit_es_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input
                                type="text"
                                name="name"
                                id="edit_es_name"
                                x-model="extraServiceToEdit.name"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            >
                            <template x-if="$store.errorBag?.errors?.['name']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['name'][0]"></p>
                            </template>
                        </div>

                        {{-- Price --}}
                        <div>
                            <label for="edit_es_price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                            <input
                                type="number"
                                name="price"
                                id="edit_es_price"
                                x-model="extraServiceToEdit.price"
                                step="0.01"
                                min="0"
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            >
                            <template x-if="$store.errorBag?.errors?.['price']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['price'][0]"></p>
                            </template>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="edit_es_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                name="description"
                                id="edit_es_description"
                                rows="3"
                                x-model="extraServiceToEdit.description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                            <template x-if="$store.errorBag?.errors?.['description']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['description'][0]"></p>
                            </template>
                        </div>

                        {{-- Botones Cancel / Save --}}
                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button
                                    @click="showEditModal = false; extraServiceToEdit = null"
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

    {{-- =============================== --}}
    {{-- MODAL: Delete Extra Service    --}}
    {{-- =============================== --}}
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
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Caja del modal --}}
            <div
                x-show="showDeleteModal"
                @click.outside="showDeleteModal = false; extraServiceIdToDelete = null; extraServiceNameToDelete = ''"
                x-transition
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle"
            >
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium text-gray-900">Delete Extra Service</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete
                                "<strong x-text="extraServiceNameToDelete"></strong>"?
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form
                        :action="`/admin/extra-services/${extraServiceIdToDelete}`"
                        method="POST"
                        class="inline-block"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            :disabled="!extraServiceIdToDelete"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </form>
                    <button
                        @click="showDeleteModal = false; extraServiceIdToDelete = null; extraServiceNameToDelete = ''"
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

{{-- Alpine.js Data y Métodos para ExtraServices --}}
<script>
    function extraServicesPageData() {
        return {
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create_extra_service') ? 'true' : 'false' }},
            showViewModal: false,
            showEditModal: {{ ($errors->any() && old('_form_type') === 'edit_extra_service') ? 'true' : 'false' }},
            showDeleteModal: false,

            extraServiceToView: null,
            extraServiceToEdit: null,
            extraServiceIdToDelete: null,
            extraServiceNameToDelete: '',

            initPage() {
                @if($errors->any() && old('_form_type') === 'edit_extra_service' && old('extra_service_id_for_edit_error'))
                    let editId = {{ old('extra_service_id_for_edit_error') }};
                    let existingES = @js($extraServices->map->only(['id','name','description','price']))
                                      .find(e => e.id === editId);
                    if (existingES) {
                        this.editExtraService(existingES, true);
                    }
                @endif
            },

            viewExtraService(es) {
                if (!es) return;
                this.extraServiceToView = JSON.parse(JSON.stringify(es));
                this.showViewModal = true;
            },

            editExtraService(es, openModal = true) {
                if (!es) return;
                this.extraServiceToEdit = JSON.parse(JSON.stringify(es));
                if (openModal) {
                    this.showEditModal = true;
                }
            },

            openDeleteModal(es) {
                if (!es) return;
                this.extraServiceIdToDelete = es.id;
                this.extraServiceNameToDelete = es.name;
                this.showDeleteModal = true;
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('extraServicesPageData', extraServicesPageData);
    });
</script>
@endsection