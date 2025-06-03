<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExtraServiceController extends Controller
{
    /**
     * Mostrar todos los extra services en la vista de índice.
     */
    public function index(Request $request)
    {
        $extraServices = ExtraService::orderBy('name', 'asc')->paginate(15);
        return view('admin.extra_services.index', compact('extraServices'));
    }

    /**
     * Ruta de “fallback” para mostrar el formulario de creación si alguien navega a /admin/extra-services/create.
     */
    public function create()
    {
        return view('admin.extra_services.create_page_fallback');
    }

    /**
     * Almacenar un nuevo extra service en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:extra_services,name',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            ExtraService::create([
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price'       => $validated['price'],
            ]);
            DB::commit();

            return redirect()
                ->route('admin.extra-services.index')
                ->with('success', 'Extra Service created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create extra service: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostrar detalles de un extra service.
     */
    public function show(ExtraService $extraService)
    {
        return view('admin.extra_services.show', compact('extraService'));
    }

    /**
     * Mostrar el formulario de edición de un extra service.
     */
    public function edit(ExtraService $extraService)
    {
        return view('admin.extra_services.edit', compact('extraService'));
    }

    /**
     * Actualizar un extra service existente.
     */
    public function update(Request $request, ExtraService $extraService)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:extra_services,name,' . $extraService->id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $extraService->name        = $validated['name'];
            $extraService->description = $validated['description'] ?? null;
            $extraService->price       = $validated['price'];
            $extraService->save();

            DB::commit();
            return redirect()
                ->route('admin.extra-services.index')
                ->with('success', 'Extra Service updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update extra service: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar un extra service.
     */
    public function destroy(ExtraService $extraService)
    {
        DB::beginTransaction();
        try {
            $extraService->delete();
            DB::commit();
            return redirect()
                ->route('admin.extra-services.index')
                ->with('success', 'Extra Service deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Failed to delete extra service: ' . $e->getMessage()]);
        }
    }
}