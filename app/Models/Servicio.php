<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    protected $fillable = [
        'nombre_servicio',
        'precio',
        'id_administrador',
        'categoria',
        'imagen',
    ];

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_administrador', 'id_administrador');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_servicio', 'id_servicio');
    }
}
