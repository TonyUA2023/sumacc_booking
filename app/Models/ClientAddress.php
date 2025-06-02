<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientAddress extends Model
{
    protected $fillable = [
        'client_id',
        'street',
        'city',
        'state',
        'postal_code',
    ];

    /**
     * Cada dirección pertenece a un solo cliente.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Una dirección puede tener N citas asociadas.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'address_id');
    }
}