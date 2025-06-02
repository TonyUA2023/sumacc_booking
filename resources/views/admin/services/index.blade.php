@extends('admin.layout')

@section('title', 'Manage Services - SUMACC Admin')
@section('page-title', 'Services Management')

@section('content')
<div x-data="{ 
    showCreateModal: {{ $errors->any() && old('_form_type') === 'create_service' ? 'true' : 'false' }},
    showEditModal: false, 
    serviceToEdit: null, 
    showViewModal: false,
    serviceToView: null,
    showDeleteModal: false,
    serviceIdToDelete: null,
    serviceNameToDelete: ''
}">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                <h3 class="text-lg font-medium text-gray-700">All Services</h3>
                <div class="mt-3 sm:mt-0">
                    <button @click="showCreateModal = true" type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        Create New Service
                    </button> 
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($services->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">ID</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Name</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Category</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tagline</th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($services as $service)
                            @php
                                // Aseguramos que todas las relaciones necesarias para los modales View/Edit estén cargadas
                                $serviceDataForModal = $service->loadMissing(['category', 'serviceVehiclePrices.vehicleType']);
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">#{{ $service->id }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $service->name }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ $service->category->name ?? 'N/A' }}</div></td>
                                <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ Str::limit($service->tagline, 50) }}</div></td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <button @click="serviceToView = {{ Js::from($serviceDataForModal) }}; showViewModal = true" type="button" class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none">View</button>
                                    <button @click="serviceToEdit = {{ Js::from($serviceDataForModal) }}; showEditModal = true" type="button" class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">Edit</button>
                                    <button @click="serviceIdToDelete = {{ $service->id }}; serviceNameToDelete = '{{ addslashes($service->name) }}'; showDeleteModal = true" type="button" class="ml-4 text-red-600 hover:text-red-800 hover:underline focus:outline-none">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">
                    {{ $services->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No services found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are currently no services to display. You can create one now.</p>
                    <div class="mt-6">
                         <button @click="showCreateModal = true" type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                            Create New Service
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-create-service" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showCreateModal" @click.outside="showCreateModal = false" x-transition class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create-service">Create New Service</h3>
                    <button @click="showCreateModal = false" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
                <form action="{{ route('admin.services.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="_form_type" value="create_service">
                    <div><label for="create_service_name" class="block text-sm font-medium text-gray-700">Service Name</label><input type="text" name="name" id="create_service_name" value="{{ old('name') }}" required class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">@error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div><label for="create_service_category_id" class="block text-sm font-medium text-gray-700">Category</label><select id="create_service_category_id" name="category_id" required class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><option value="">Select a category</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select>@error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div><label for="create_service_tagline" class="block text-sm font-medium text-gray-700">Tagline</label><input type="text" name="tagline" id="create_service_tagline" value="{{ old('tagline') }}" class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">@error('tagline')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div><label for="create_service_description" class="block text-sm font-medium text-gray-700">Description</label><textarea id="create_service_description" name="description" rows="3" class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>@error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div><label for="create_service_recommendation" class="block text-sm font-medium text-gray-700">Recommendation</label><textarea id="create_service_recommendation" name="recommendation" rows="2" class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('recommendation') }}</textarea>@error('recommendation')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror</div>
                    <div class="pt-4 mt-4 border-t"><h4 class="text-md font-medium text-gray-800">Pricing per Vehicle Type</h4><p class="text-sm text-gray-500">Pricing will be managed in the Edit Service screen after creation.</p></div>
                    <div class="pt-6 mt-8 border-t border-gray-200"><div class="flex justify-end space-x-3"><button @click="showCreateModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Cancel</button><button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">Create Service</button></div></div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showViewModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-view-service" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showViewModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showViewModal" @click.outside="showViewModal = false; serviceToView = null" x-transition class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title-view-service">Service Details: <span x-text="serviceToView ? serviceToView.name : ''"></span></h3>
                    <button @click="showViewModal = false; serviceToView = null" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
                
                <div x-if="serviceToView" class="space-y-6">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="mb-3 text-lg font-medium text-gray-800">General Information</h4>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Name</dt><dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.name"></dd></div>
                            <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Category</dt><dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.category ? serviceToView.category.name : 'N/A'"></dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Tagline</dt><dd class="mt-1 text-sm text-gray-900" x-text="serviceToView.tagline || 'N/A'"></dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Description</dt><dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap" x-text="serviceToView.description || 'N/A'"></dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Recommendation</dt><dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap" x-text="serviceToView.recommendation || 'N/A'"></dd></div>
                        </dl>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="mb-3 text-lg font-medium text-gray-800">Pricing per Vehicle Type</h4>
                        <div x-show="serviceToView.service_vehicle_prices && serviceToView.service_vehicle_prices.length > 0">
                            <ul class="divide-y divide-gray-200">
                                <template x-for="priceInfo in serviceToView.service_vehicle_prices" :key="priceInfo.id">
                                    <li class="flex items-center justify-between py-3">
                                        <span class="text-sm text-gray-700" x-text="priceInfo.vehicle_type ? priceInfo.vehicle_type.name : 'Unknown Vehicle Type'"></span>
                                        <span class="text-sm font-semibold text-gray-900" x-text="priceInfo.price ? '$' + parseFloat(priceInfo.price).toFixed(2) : 'N/A'"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div x-show="!serviceToView.service_vehicle_prices || serviceToView.service_vehicle_prices.length === 0">
                            <p class="text-sm text-gray-500">No pricing information set for this service.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-8 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <button @click="showViewModal = false; serviceToView = null" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Close</button>
                        <button @click="serviceToEdit = serviceToView; showViewModal = false; showEditModal = true;" type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700">Edit Service</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Edición (Placeholder) --}}
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEditModal" x-transition class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="showEditModal" @click.outside="showEditModal = false; serviceToEdit = null" x-transition class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                <div class="flex items-center justify-between pb-4 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Edit Service <span x-text="serviceToEdit ? '#' + serviceToEdit.id : ''"></span></h3>
                    <button @click="showEditModal = false; serviceToEdit = null" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
                <div class="mt-6" x-if="serviceToEdit">
                    <p>Edit form for service <strong x-text="serviceToEdit.name"></strong> will go here.</p>
                    <p class="text-gray-600 mt-2">This will include fields for name, category, tagline, description, recommendation, and a section to manage prices per vehicle type.</p>
                    {{-- El formulario de edición completo irá aquí --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Eliminación (Placeholder) --}}
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
         <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showDeleteModal" x-transition class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div x-show="showDeleteModal" @click.outside="showDeleteModal = false; serviceIdToDelete = null; serviceNameToDelete = ''" x-transition class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium text-gray-900">Delete Service</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete the service "<strong x-text="serviceNameToDelete"></strong>"? This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <form :action="serviceIdToDelete ? `{{ url('admin/services') }}/${serviceIdToDelete}` : '#'" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" :disabled="!serviceIdToDelete" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">Delete</button>
                    </form>
                    <button @click="showDeleteModal = false; serviceIdToDelete = null; serviceNameToDelete = ''" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function servicesPageData() {
        return {
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create_service') || session('open_create_service_modal') ? 'true' : 'false' }},
            showEditModal: {{ ($errors->any() && old('_form_type') === 'edit_service') || session('open_edit_service_modal') ? 'true' : 'false' }},
            serviceToEdit: {{ session('service_to_edit_on_error') ? Js::from(session('service_to_edit_on_error')) : (old('_form_type') === 'edit_service' && old('service_id_for_edit_error') ? '{ "id": ' . Js::from(old('service_id_for_edit_error')) . ' }' : 'null') }},
            showViewModal: false, 
            serviceToView: null,
            showDeleteModal: false,
            serviceIdToDelete: null,
            serviceNameToDelete: '',

            initPage() {
                if (this.showCreateModal) { }
                if (this.showEditModal && this.serviceToEdit) {
                    // Si se reabre por error de validación y tenemos el serviceToEdit desde la sesión,
                    // podríamos necesitar reprocesarlo como en la función editService para asegurar formato.
                    // this.editService(this.serviceToEdit, false); // 'false' para no mostrar el modal de nuevo si ya está por abrirse
                }
            },

            editService(serviceData, openModal = true) { // openModal es para controlar si se muestra el modal o solo se preparan datos
                if(!serviceData) return;
                
                let clonedData = JSON.parse(JSON.stringify(serviceData));
                clonedData.category_id = clonedData.category ? clonedData.category.id : null;

                // Preparar precios para el formulario de edición (esto lo haremos más adelante)
                // clonedData.prices_attributes = clonedData.service_vehicle_prices 
                //     ? clonedData.service_vehicle_prices.map(svp => ({ 
                //         id: svp.id, // para actualizar existentes
                //         vehicle_type_id: svp.vehicle_type_id, 
                //         price: svp.price,
                //         _destroy: false // para marcar para eliminación
                //     })) 
                //     : [];
                // delete clonedData.service_vehicle_prices;
                // delete clonedData.category;


                this.serviceToEdit = clonedData;
                if(openModal) {
                    this.showEditModal = true;
                }
            }
        }
    }
    document.addEventListener('alpine:init', () => {
        Alpine.data('servicesPageData', servicesPageData);
    });
</script>
@endsection