<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientAddress;
use App\Models\Client;

class ClientAddressController extends Controller
{
    /**
     * Store a new address for a given client (client_id).
     * Receives: client_id, street, city, state, postal_code
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'street'      => 'required|string|max:200',
            'city'        => 'required|string|max:100',
            'state'       => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        // Verify that the client_id exists
        $client = Client::findOrFail($data['client_id']);

        $address = ClientAddress::create([
            'client_id'   => $client->id,
            'street'      => $data['street'],
            'city'        => $data['city'],
            'state'       => $data['state'],
            'postal_code' => $data['postal_code'],
        ]);

        return response()->json([
            'message' => 'Address added successfully.',
            'address' => $address,
        ], 201);
    }
}