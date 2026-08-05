<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    // Por defecto, Laravel usa la columna "password" por lo que no es necesario sobreescribir getAuthPassword.
}
