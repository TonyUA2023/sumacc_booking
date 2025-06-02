<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
// Lo hacemos “Authenticatable” para poder usar el guard admin en Auth si fuera el caso.
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use Notifiable;

    // Si vas a usar Auth para admins, en config/auth.php deberías agregar un guard 'admin' que apunte a este modelo.

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'first_name',
        'last_name',
    ];

    // Si prefieres que Laravel espere la columna "password" en lugar de "password_hash",
    // cambia esta propiedad:
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Un admin puede haber modificado múltiples citas.
     */
    public function appointmentsUpdated(): HasMany
    {
        return $this->hasMany(Appointment::class, 'updated_by_admin_id');
    }

    /**
     * Un admin puede haber registrado cambios de estado en las citas.
     */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(AppointmentStatusHistory::class, 'changed_by_admin_id');
    }
}