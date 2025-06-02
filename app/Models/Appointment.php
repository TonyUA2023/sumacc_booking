<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $fillable = [
        'client_id',
        'address_id',
        'scheduled_at',
        'service_id',
        'vehicle_type_id',
        'monto_final',
        'notas',
        'status',
        'updated_by_admin_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime', // Para que Eloquent haga cast automático a Carbon
    ];

    /**
     * Cada cita pertenece a un cliente.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Cada cita se asocia a una dirección del cliente.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(ClientAddress::class, 'address_id');
    }

    /**
     * Cada cita pertenece a un servicio.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Cada cita está asociada a un tipo de vehículo.
     */
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Cada cita puede tener muchos servicios extra (pivot).
     */
    public function extraServices(): HasMany
    {
        return $this->hasMany(AppointmentExtraService::class);
    }

    /**
     * Quién fue el admin que modificó por última vez.
     */
    public function updatedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by_admin_id');
    }

    /**
     * Historial de cambios de estado
     */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(AppointmentStatusHistory::class);
    }

    /**
     * Pagos asociados (opcional).
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}