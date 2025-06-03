{{-- resources/views/admin/services/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manage Services - SUMACC Admin')
@section('page-title', 'Services Management')

@section('content')
<div x-data="servicesData()" x-init="init()" class="space-y-6">
    {{-- Container blanco con sombra para el encabezado y botón “Create New Service” --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                <h3 class="text-lg font-medium text-gray-700">All Services</h3>
                <div class="mt-3 sm:mt-0">
                    <button
                        @click="showCreateModal = true"
                        type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create New Service
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid de Cards para cada servicio --}}
    @if($services->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                @php
                    // Cargar relaciones necesarias en este momento:
                    $serviceForJs = $service->loadMissing([
                        'category',
                        'serviceVehiclePrices.vehicleType'
                    ]);
                @endphp

                <div class="bg-white rounded-lg shadow flex flex-col">
                    {{-- Sección superior: información general --}}
                    <div class="p-4 flex-1 flex flex-col">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $service->name }}</h2>
                        <p class="text-sm text-gray-600 mb-1">
                            <strong>Category:</strong> {{ $service->category->name ?? 'N/A' }}
                        </p>
                        @if($service->tagline)
                            <p class="text-sm italic text-gray-700 mb-2">"{{ $service->tagline }}"</p>
                        @endif
                        @if($service->description)
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                        @endif

                        {{-- Botones de acción --}}
                        <div class="mt-auto">
                            <button
                                @click="openView(@js($serviceForJs))"
                                class="text-indigo-600 hover:underline text-sm font-medium"
                            >
                                View
                            </button>
                            <button
                                @click="openEdit(@js($serviceForJs))"
                                class="ml-4 text-blue-600 hover:underline text-sm font-medium"
                            >
                                Edit
                            </button>
                            <button
                                @click="openDelete(@js($serviceForJs))"
                                class="ml-4 text-red-600 hover:underline text-sm font-medium"
                            >
                                Delete
                            </button>
                        </div>
                    </div>

                    {{-- Sección inferior: precios por tipo de vehículo --}}
                    <div class="bg-gray-50 border-t border-gray-200 p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Pricing per Vehicle</h3>
                        <ul class="divide-y divide-gray-200">
                            @foreach($service->serviceVehiclePrices as $svp)
                                <li class="flex justify-between py-2">
                                    <span class="text-sm text-gray-600">
                                        {{ $svp->vehicleType->name }}
                                    </span>
                                    <span class="text-sm font-semibold text-gray-800">
                                        S/{{ number_format($svp->price, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="pt-4">
            {{ $services->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No services found</h3>
            <p class="mt-1 text-sm text-gray-500">
                There are currently no services to display. You can create one now.
            </p>
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
                    Create New Service
                </button>
            </div>
        </div>
    @endif

    {{-- ================================================= --}}
    {{-- MODAL: Create New Service --}}
    {{-- ================================================= --}}
    <div
        x-show="showCreateModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-create-service"
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
                class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create-service">
                        Create New Service
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

                <form action="{{ route('admin.services.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="_form_type" value="create_service">

                    {{-- Nombre del servicio --}}
                    <div>
                        <label for="create_service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input
                            type="text"
                            name="name"
                            id="create_service_name"
                            value="{{ old('name') }}"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="create_service_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select
                            id="create_service_category_id"
                            name="category_id"
                            required
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tagline --}}
                    <div>
                        <label for="create_service_tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                        <input
                            type="text"
                            name="tagline"
                            id="create_service_tagline"
                            value="{{ old('tagline') }}"
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @error('tagline')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="create_service_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            id="create_service_description"
                            name="description"
                            rows="3"
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Recomendación --}}
                    <div>
                        <label for="create_service_recommendation" class="block text-sm font-medium text-gray-700">Recommendation</label>
                        <textarea
                            id="create_service_recommendation"
                            name="recommendation"
                            rows="2"
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >{{ old('recommendation') }}</textarea>
                        @error('recommendation')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Precios por cada tipo de vehículo --}}
                    <div class="pt-4 mt-4 border-t">
                        <h4 class="text-md font-medium text-gray-800">Pricing per Vehicle Type</h4>
                    </div>
                    @foreach($vehicleTypes as $vt)
                        <div class="flex items-center space-x-4">
                            <input
                                type="hidden"
                                name="prices[{{ $vt->id }}][vehicle_type_id]"
                                value="{{ $vt->id }}"
                            >
                            <label class="w-1/3 text-sm font-medium text-gray-700">{{ $vt->name }}</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="prices[{{ $vt->id }}][price]"
                                value="{{ old("prices.{$vt->id}.price") }}"
                                placeholder="0.00"
                                required
                                class="w-2/3 px-3 py-2 mt-1 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                        </div>
                        @error("prices.{$vt->id}.price")
                            <p class="mt-1 ml-20 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    @endforeach

                    {{-- Botones de Cancel / Create --}}
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
                                Create Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: View Service Details --}}
    {{-- ================================================= --}}
    <div
        x-show="showViewModal"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title-view-service"
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
                @click.outside="showViewModal = false; serviceToView = null"
                x-transition
                class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title-view-service">
                        Service Details: <span class="font-bold" x-text="serviceToView ? serviceToView.name : ''"></span>
                    </h3>
                    <button
                        @click="showViewModal = false; serviceToView = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="serviceToView">
                    <div class="space-y-6">
                        {{-- Información general --}}
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 text-lg font-medium text-gray-800">General Information</h4>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.name"></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.category ? serviceToView.category.name : 'N/A'"></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Tagline</dt>
                                    <dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.tagline || 'N/A'"></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap" x-text="serviceToView.description || 'N/A'"></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Recommendation</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap" x-text="serviceToView.recommendation || 'N/A'"></dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Precios --}}
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 text-lg font-medium text-gray-800">Pricing per Vehicle Type</h4>
                            <div x-show="serviceToView.service_vehicle_prices && serviceToView.service_vehicle_prices.length > 0">
                                <ul class="divide-y divide-gray-200">
                                    <template x-for="priceInfo in serviceToView.service_vehicle_prices" :key="priceInfo.id">
                                        <li class="flex items-center justify-between py-3">
                                            <span class="text-sm text-gray-700" x-text="priceInfo.vehicle_type ? priceInfo.vehicle_type.name : 'Unknown Vehicle Type'"></span>
                                            <span class="text-sm font-semibold text-gray-900" x-text="priceInfo.price ? 'S/' + parseFloat(priceInfo.price).toFixed(2) : 'N/A'"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            <div x-show="!serviceToView.service_vehicle_prices || serviceToView.service_vehicle_prices.length === 0">
                                <p class="text-sm text-gray-500">No pricing information set for this service.</p>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showViewModal = false; serviceToView = null"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                        >
                            Close
                        </button>
                        <button
                            @click="openEdit(serviceToView); showViewModal = false"
                            type="button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700"
                        >
                            Edit Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- MODAL: Edit Service --}}
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
                @click.outside="showEditModal = false; serviceToEdit = null"
                x-transition
                class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle"
            >
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">
                        Edit Service&nbsp;<span class="font-semibold" x-text="serviceToEdit ? '#' + serviceToEdit.id : ''"></span>
                    </h3>
                    <button
                        @click="showEditModal = false; serviceToEdit = null"
                        type="button"
                        class="text-gray-400 hover:text-gray-500 focus:outline-none"
                    >
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="serviceToEdit">
                    <form
                        :action="`/admin/services/${serviceToEdit.id}`"
                        method="POST"
                        class="mt-6 space-y-6"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form_type" value="edit_service">
                        <input type="hidden" name="service_id_for_edit_error" :value="serviceToEdit.id">

                        {{-- Name --}}
                        <div>
                            <label for="edit_service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                            <input
                                type="text"
                                name="name"
                                id="edit_service_name"
                                x-model="serviceToEdit.name"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            <template x-if="$store.errorBag?.errors?.['name']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['name'][0]"></p>
                            </template>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="edit_service_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select
                                id="edit_service_category_id"
                                name="category_id"
                                x-model.number="serviceToEdit.category_id"
                                required
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                                <option value="">Select a category</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                            <template x-if="$store.errorBag?.errors?.['category_id']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['category_id'][0]"></p>
                            </template>
                        </div>

                        {{-- Tagline --}}
                        <div>
                            <label for="edit_service_tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                            <input
                                type="text"
                                name="tagline"
                                id="edit_service_tagline"
                                x-model="serviceToEdit.tagline"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            >
                            <template x-if="$store.errorBag?.errors?.['tagline']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['tagline'][0]"></p>
                            </template>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="edit_service_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                id="edit_service_description"
                                name="description"
                                rows="3"
                                x-model="serviceToEdit.description"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            ></textarea>
                            <template x-if="$store.errorBag?.errors?.['description']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['description'][0]"></p>
                            </template>
                        </div>

                        {{-- Recommendation --}}
                        <div>
                            <label for="edit_service_recommendation" class="block text-sm font-medium text-gray-700">Recommendation</label>
                            <textarea
                                id="edit_service_recommendation"
                                name="recommendation"
                                rows="2"
                                x-model="serviceToEdit.recommendation"
                                class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            ></textarea>
                            <template x-if="$store.errorBag?.errors?.['recommendation']">
                                <p class="mt-1 text-xs text-red-500" x-text="$store.errorBag.errors['recommendation'][0]"></p>
                            </template>
                        </div>

                        {{-- Precios por tipo de vehículo --}}
                        <div class="pt-4 mt-4 border-t">
                            <h4 class="text-md font-medium text-gray-800">Pricing per Vehicle Type</h4>
                        </div>
                        <template x-for="(priceObj, idx) in serviceToEdit.prices" :key="priceObj.vehicle_type_id">
                            <div class="flex items-center space-x-4 mt-2">
                                <input type="hidden" :name="`prices[${priceObj.vehicle_type_id}][id]`" :value="priceObj.id">
                                <input type="hidden" :name="`prices[${priceObj.vehicle_type_id}][vehicle_type_id]`" :value="priceObj.vehicle_type_id">
                                <label class="w-1/3 text-sm font-medium text-gray-700"
                                       x-text="vehicleTypes.find(v => v.id === priceObj.vehicle_type_id).name">
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    :name="`prices[${priceObj.vehicle_type_id}][price]`"
                                    x-model="priceObj.price"
                                    placeholder="0.00"
                                    required
                                    class="w-2/3 px-3 py-2 mt-1 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                <template x-if="$store.errorBag?.errors?.[`prices.${priceObj.vehicle_type_id}.price`]">
                                    <p class="mt-1 text-xs text-red-500"
                                       x-text="$store.errorBag.errors[`prices.${priceObj.vehicle_type_id}.price`][0]">
                                    </p>
                                </template>
                            </div>
                        </template>

                        {{-- Botones Cancel / Save --}}
                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button
                                    @click="showEditModal = false; serviceToEdit = null"
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
    {{-- MODAL: Delete Service Confirmation --}}
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
                @click.outside="showDeleteModal = false; serviceIdToDelete = null; serviceNameToDelete = ''"
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
                        <h3 class="text-lg font-medium text-gray-900">Delete Service</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete the service
                                "<strong x-text="serviceNameToDelete"></strong>"? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form
                        :action="`/admin/services/${serviceIdToDelete}`"
                        method="POST"
                        class="inline-block"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            :disabled="!serviceIdToDelete"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </form>
                    <button
                        @click="showDeleteModal = false; serviceIdToDelete = null; serviceNameToDelete = ''"
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

{{-- Alpine.js Data y Métodos --}}
<script>
    function servicesData() {
        return {
            // Listado de categorías y tipos de vehículo pasados desde el controlador
            categories: @json($categories),
            vehicleTypes: @json($vehicleTypes),

            // Modales
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create_service') ? 'true' : 'false' }},
            showViewModal: false,
            showEditModal: {{ ($errors->any() && old('_form_type') === 'edit_service') ? 'true' : 'false' }},
            showDeleteModal: false,

            // Objetos dinámicos
            serviceToView: null,
            serviceToEdit: null,
            serviceIdToDelete: null,
            serviceNameToDelete: '',

            init() {
                // Si hubo errores de validación del formulario de edición,
                // reconstruimos 'serviceToEdit' para que Alpine muestre el modal con datos previos.
                @if($errors->any() && old('_form_type') === 'edit_service' && old('service_id_for_edit_error'))
                    let oldId = {{ old('service_id_for_edit_error') }};
                    // Encontrar el servicio en la lista de servicios disponibles
                    let svc = @js($services->map->only(['id','name','category','tagline','description','recommendation','serviceVehiclePrices'])) 
                                .find(s => s.id === oldId);
                    if (svc) {
                        // Reconstruir objeto edit
                        this.openEdit(svc);
                        // Luego Alpine rellenará los campos con old() mediante los bindings en inputs
                    }
                @endif
            },

            openView(service) {
                // Asegurarse de que el objeto tenga category y service_vehicle_prices con vehicle_type
                this.serviceToView = JSON.parse(JSON.stringify(service));
                this.showViewModal = true;
            },

            openEdit(service) {
                // Deep clone para no modificar el objeto original
                let clone = JSON.parse(JSON.stringify(service));

                // Asegurarse de que exista arreglo 'service.vehicle_type_prices' y método de acceso:
                // Convertir service.service_vehicle_prices a un array de objetos { id, vehicle_type_id, price }
                let pricesArray = this.vehicleTypes.map(vt => {
                    let found = clone.service_vehicle_prices.find(p => p.vehicle_type_id === vt.id);
                    return {
                        id: found ? found.id : null,
                        vehicle_type_id: vt.id,
                        price: found ? found.price : ''
                    };
                });

                this.serviceToEdit = {
                    id: clone.id,
                    name: clone.name,
                    category_id: clone.category ? clone.category.id : null,
                    tagline: clone.tagline || '',
                    description: clone.description || '',
                    recommendation: clone.recommendation || '',
                    prices: pricesArray
                };

                this.showEditModal = true;
            },

            openDelete(service) {
                this.serviceIdToDelete = service.id;
                this.serviceNameToDelete = service.name;
                this.showDeleteModal = true;
            }
        }
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('servicesData', servicesData);
    });
</script>
@endsection