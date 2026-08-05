<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrador extends Authenticatable
{
    use HasFactory;

    protected $table = 'administrador';
    protected $primaryKey = 'id_administrador';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'usuario',
        'contraseña',
    ];

    /**
     * Get the password for the user (for Laravel Auth).
     */
    public function getAuthPassword()
    {
        // En este proyecto, el administrador usa la columna "contraseña"
        return $this->contraseña;
    }
}
