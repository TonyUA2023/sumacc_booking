<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * Create a NEW client or return the existing one if an email match is found.
     * Receives: first_name, last_name, email, phone
     */
    public function storeOrGet(Request $request)
    {
        // Basic validation
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:150',
            'phone'      => 'required|string|max:30',
        ]);

        // Try to find by email:
        $client = Client::where('email', $data['email'])->first();

        if ($client) {
            // Update name/last_name/phone in case they changed
            $client->update([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'phone'      => $data['phone'],
            ]);

            return response()->json([
                'message' => 'Existing client updated.',
                'client'  => $client,
            ], 200);
        }

        // If not found, create a new client
        $newClient = Client::create($data);

        return response()->json([
            'message' => 'Client created successfully.',
            'client'  => $newClient,
        ], 201);
    }
}