<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraService;

class ExtraServiceController extends Controller
{
    /**
     * Return all optional extra services.
     */
    public function index()
    {
        $extras = ExtraService::all();

        return response()->json([
            'extra_services' => $extras
        ], 200);
    }
}