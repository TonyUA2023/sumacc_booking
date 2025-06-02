<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class PageController extends Controller
{
    /**
     * Display the "Services" page, listing all available services
     * (with category and per-vehicle prices) so the client can choose one.
     */
    public function servicesPage()
    {
        // Eager-load each service’s category and the related prices per vehicle type
        $services = Service::with([
            'category',
            'serviceVehiclePrices.vehicleType'
        ])->get();

        return view('public.services', compact('services'));
    }
}