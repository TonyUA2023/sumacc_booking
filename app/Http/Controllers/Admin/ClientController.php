<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientAddress; // Para manejar direcciones
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para transacciones

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Podrías añadir filtros por nombre, email, etc.
        $clients = Client::withCount('addresses', 'appointments') // Contar direcciones y citas
                         ->orderBy('last_name', 'asc')
                         ->orderBy('first_name', 'asc')
                         ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        // Esta lógica ahora está principalmente en index() para el modal.
        // Puedes mantener esta ruta y método como un fallback.
        return view('admin.clients.create_page_fallback'); // Necesitarías esta vista
    }

    public function store(Request $request)
    {
        $validatedClientData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:30',
        ]);

        $validatedAddressData = $request->validate([
            'address_street' => 'nullable|string|max:255',
            'address_city' => 'nullable|string|max:100',
            'address_state' => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',
        ]);
        
        // Solo crear dirección si se proporcionó al menos la calle
        $hasAddressData = !empty($validatedAddressData['address_street']);

        DB::beginTransaction();
        try {
            $client = Client::create($validatedClientData);

            if ($hasAddressData) {
                $client->addresses()->create([
                    'street' => $validatedAddressData['address_street'],
                    'city' => $validatedAddressData['address_city'],
                    'state' => $validatedAddressData['address_state'],
                    'postal_code' => $validatedAddressData['address_postal_code'],
                    // Podrías añadir un campo 'is_primary' o 'address_type' aquí
                ]);
            }
            DB::commit();
            return redirect()->route('admin.clients.index')->with('success', 'Client created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create client: ' . $e->getMessage()]);
        }
    }

    // Implementar show, edit, update, destroy más adelante
    // public function show(Client $client) { $client->load('addresses', 'appointments'); return view('admin.clients.show', compact('client')); }
    // public function edit(Client $client) { $client->load('addresses'); return view('admin.clients.edit', compact('client')); }
    // public function update(Request $request, Client $client) { /* ... */ }
    // public function destroy(Client $client) { /* ... */ }
}