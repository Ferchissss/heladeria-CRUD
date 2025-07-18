<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    /** @use HasFactory<\Database\Factories\PromocionFactory> */
    use HasFactory;
    protected $primaryKey = 'promocion_id';
    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'descuento_porcentaje',
        'descuento_monto',
        'fecha_inicio',
        'fecha_fin',
        'codigo_promocional',
        'min_compra',
        'max_usos',
        'usos_actuales',
        'activa',
    ];
}
