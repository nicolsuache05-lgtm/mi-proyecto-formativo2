<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleServicio extends Model
{
    use HasFactory;

    protected $table = 'detalle_servicio';
    protected $primaryKey = 'id_detalle_servicio';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'subtotal',
        'id_reserva',
        'id_servicio',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}
