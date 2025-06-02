<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Return all services, each with its category and vehicle-type–based prices.
     */
    public function index()
    {
        $services = Service::with(['category', 'serviceVehiclePrices.vehicleType'])
                           ->get();

        return response()->json([
            'services' => $services
        ], 200);
    }
}