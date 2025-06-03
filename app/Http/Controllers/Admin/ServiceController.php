<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\VehicleType;
use App\Models\ServiceVehiclePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a paginated list of all services (with category and per-vehicle prices).
     */
    public function index(Request $request)
    {
        // Eager-load category and serviceVehiclePrices → vehicleType
        $services = Service::with([
                'category',
                'serviceVehiclePrices.vehicleType',
            ])
            ->orderBy('name', 'asc')
            ->paginate(15);

        // Categories and vehicle types para poblar los selects/modales
        $categories   = Category::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'vehicleTypes'
        ));
    }

    /**
     * Show the form to create a new service.
     * Se espera que la vista muestre campos básicos (name, category, tagline, etc.)
     * y también un input para cada VehicleType (un campo “price” por cada tipo).
     */
    public function create()
    {
        $categories   = Category::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('admin.services.create', compact('categories', 'vehicleTypes'));
    }

    /**
     * Store a newly created service in storage, junto con sus precios por tipo de vehículo.
     */
    public function store(Request $request)
    {
        // Validar datos:
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name',
            'category_id'    => 'required|exists:categories,id',
            'tagline'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'recommendation' => 'nullable|string',
            // 'prices' debe contener un precio para CADA vehicle_type_id en la BD
            'prices'              => 'required|array',
            'prices.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'prices.*.price'           => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1) Crear el servicio
            $service = Service::create([
                'name'           => $validated['name'],
                'category_id'    => $validated['category_id'],
                'tagline'        => $validated['tagline'] ?? null,
                'description'    => $validated['description'] ?? null,
                'recommendation' => $validated['recommendation'] ?? null,
            ]);

            // 2) Guardar precios por tipo de vehículo
            foreach ($validated['prices'] as $priceData) {
                ServiceVehiclePrice::create([
                    'service_id'      => $service->id,
                    'vehicle_type_id' => $priceData['vehicle_type_id'],
                    'price'           => $priceData['price'],
                ]);
            }

            DB::commit();
            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['general' => 'Error creating service. Please try again.']);
        }
    }

    /**
     * Display the specified service (detalles + precios).
     * Puede usarse para obtener datos via AJAX/modal o para una vista separada.
     */
    public function show(Service $service)
    {
        // Asegurarse de cargar categoría y precios → vehicleType
        $service->load(['category', 'serviceVehiclePrices.vehicleType']);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $service->load(['category', 'serviceVehiclePrices']);
        $categories   = Category::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('admin.services.edit', compact(
            'service',
            'categories',
            'vehicleTypes'
        ));
    }

    /**
     * Update the specified service in storage, junto con su conjunto de precios.
     */
    public function update(Request $request, Service $service)
    {
        // Validar datos básicos y arreglo de precios
        $validated = $request->validate([
            'name'           => 'required|string|max:255|unique:services,name,' . $service->id,
            'category_id'    => 'required|exists:categories,id',
            'tagline'        => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'recommendation' => 'nullable|string',
            // Precios: debe venir un arreglo con un precio para cada vehicle_type_id
            'prices'              => 'required|array',
            'prices.*.id'         => 'nullable|exists:service_vehicle_prices,id',
            'prices.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'prices.*.price'           => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1) Actualizar campos básicos del servicio
            $service->update([
                'name'           => $validated['name'],
                'category_id'    => $validated['category_id'],
                'tagline'        => $validated['tagline'] ?? null,
                'description'    => $validated['description'] ?? null,
                'recommendation' => $validated['recommendation'] ?? null,
            ]);

            // 2) Sincronizar precios por tipo de vehículo
            // -- Construir un arreglo de IDs de precios que vinieron por el form
            $submittedPriceIds = collect($validated['prices'])
                ->pluck('id')
                ->filter() // descartar nulos
                ->all();

            // Eliminar cualquier precio que exista en BD pero no en el form (si se decide eliminar)
            ServiceVehiclePrice::where('service_id', $service->id)
                ->whereNotIn('id', $submittedPriceIds)
                ->delete();

            // Recorrer cada priceItem enviado:
            foreach ($validated['prices'] as $priceData) {
                if (!empty($priceData['id'])) {
                    // a) Si viene con id: actualizar registro existente
                    ServiceVehiclePrice::where('id', $priceData['id'])
                        ->update([
                            'vehicle_type_id' => $priceData['vehicle_type_id'],
                            'price'           => $priceData['price'],
                        ]);
                } else {
                    // b) Si no viene id: crear nuevo registro
                    ServiceVehiclePrice::create([
                        'service_id'      => $service->id,
                        'vehicle_type_id' => $priceData['vehicle_type_id'],
                        'price'           => $priceData['price'],
                    ]);
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['general' => 'Error updating service. Please try again.']);
        }
    }

    /**
     * Remove the specified service from storage (y sus precios relacionados).
     */
    public function destroy(Service $service)
    {
        DB::beginTransaction();
        try {
            // Primero, eliminar los precios asociados
            ServiceVehiclePrice::where('service_id', $service->id)->delete();

            // Luego, eliminar el servicio
            $service->delete();

            DB::commit();
            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service deleted successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withErrors(['general' => 'Error deleting service. Please try again.']);
        }
    }
}