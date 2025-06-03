<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a paginated list of clients, with counts for addresses and appointments.
     */
    public function index(Request $request)
    {
        $clients = Client::withCount('addresses', 'appointments')
                         ->orderBy('last_name', 'asc')
                         ->orderBy('first_name', 'asc')
                         ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show fallback create page (not used if using modal).
     */
    public function create()
    {
        return view('admin.clients.create_page_fallback');
    }

    /**
     * Store a newly created client, optionally with a primary address.
     */
    public function store(Request $request)
    {
        $validatedClientData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|string|email|max:255|unique:clients,email',
            'phone'      => 'nullable|string|max:30',
        ]);

        $validatedAddressData = $request->validate([
            'address_street'      => 'nullable|string|max:255',
            'address_city'        => 'nullable|string|max:100',
            'address_state'       => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',
        ]);

        $hasAddressData = !empty($validatedAddressData['address_street']);

        DB::beginTransaction();
        try {
            $client = Client::create($validatedClientData);

            if ($hasAddressData) {
                $client->addresses()->create([
                    'street'      => $validatedAddressData['address_street'],
                    'city'        => $validatedAddressData['address_city'],
                    'state'       => $validatedAddressData['address_state'],
                    'postal_code' => $validatedAddressData['address_postal_code'],
                ]);
            }

            DB::commit();
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Client created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create client: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified client's details (addresses, appointments).
     */
    public function show(Client $client)
    {
        $client->load(['addresses', 'appointments']);
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        $client->load('addresses');
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client and their primary address (if provided).
     */
    public function update(Request $request, Client $client)
    {
        $validatedClientData = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => "required|string|email|max:255|unique:clients,email,{$client->id}",
            'phone'      => 'nullable|string|max:30',
        ]);

        $validatedAddressData = $request->validate([
            'address_street'      => 'nullable|string|max:255',
            'address_city'        => 'nullable|string|max:100',
            'address_state'       => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',
        ]);

        $hasAddressData = !empty($validatedAddressData['address_street']);

        DB::beginTransaction();
        try {
            // Update client fields
            $client->update($validatedClientData);

            // Handle address: assume only one “primary” address to update or create
            $primaryAddress = $client->addresses()->first();

            if ($hasAddressData) {
                if ($primaryAddress) {
                    // Update existing address
                    $primaryAddress->update([
                        'street'      => $validatedAddressData['address_street'],
                        'city'        => $validatedAddressData['address_city'],
                        'state'       => $validatedAddressData['address_state'],
                        'postal_code' => $validatedAddressData['address_postal_code'],
                    ]);
                } else {
                    // Create new address
                    $client->addresses()->create([
                        'street'      => $validatedAddressData['address_street'],
                        'city'        => $validatedAddressData['address_city'],
                        'state'       => $validatedAddressData['address_state'],
                        'postal_code' => $validatedAddressData['address_postal_code'],
                    ]);
                }
            } else {
                // If no address data provided, optionally delete existing primary address
                if ($primaryAddress) {
                    $primaryAddress->delete();
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Client updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update client: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified client and cascade delete their addresses.
     */
    public function destroy(Client $client)
    {
        DB::beginTransaction();
        try {
            // Delete all addresses for this client
            $client->addresses()->delete();

            // Delete client
            $client->delete();

            DB::commit();
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Client deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Failed to delete client: ' . $e->getMessage()]);
        }
    }
}