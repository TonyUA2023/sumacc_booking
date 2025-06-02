<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceVehiclePrice extends Model
{
    protected $fillable = [
        'service_id',
        'vehicle_type_id',
        'price',
    ];

    /**
     * Precio pertenece a un servicio.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Precio pertenece a un tipo de vehículo.
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }
}