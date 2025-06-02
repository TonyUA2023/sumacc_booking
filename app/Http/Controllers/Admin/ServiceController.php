<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;    // Para el select de categorías
use App\Models\VehicleType; // Para la sección de precios por tipo de vehículo
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with([
            'category', 
            'serviceVehiclePrices.vehicleType' // Clave para mostrar precios por tipo de vehículo
        ])
        ->orderBy('name', 'asc')
        ->paginate(15);

        $categories = Category::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'vehicleTypes'
        ));
    }


    public function create()
    {
        // Esta lógica ahora está principalmente en index() para el modal.
        // Puedes mantener esta ruta y método como un fallback.
        $categories = Category::orderBy('name')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();
        return view('admin.services.create_page_fallback', compact('categories', 'vehicleTypes')); // Necesitarías esta vista
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'category_id' => 'required|exists:categories,id',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'recommendation' => 'nullable|string',
            // Validación para precios (vendrá en el siguiente paso)
            // 'prices' => 'nullable|array',
            // 'prices.*.vehicle_type_id' => 'required_with:prices.*.price|exists:vehicle_types,id',
            // 'prices.*.price' => 'required_with:prices.*.vehicle_type_id|numeric|min:0',
        ]);

        $service = Service::create($validatedData);

        // Lógica para guardar ServiceVehiclePrices (vendrá en el siguiente paso)
        // if ($request->has('prices')) {
        //     foreach ($request->prices as $priceData) {
        //         if (!empty($priceData['vehicle_type_id']) && isset($priceData['price'])) {
        //             $service->serviceVehiclePrices()->create([
        //                 'vehicle_type_id' => $priceData['vehicle_type_id'],
        //                 'price' => $priceData['price'],
        //             ]);
        //         }
        //     }
        // }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    // Implementar show, edit, update, destroy más adelante
    // public function show(Service $service) { /* ... */ }
    // public function edit(Service $service) { /* ... */ }
    // public function update(Request $request, Service $service) { /* ... */ }
    // public function destroy(Service $service) { /* ... */ }
}