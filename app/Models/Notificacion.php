<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    /** @use HasFactory<\Database\Factories\NotificacionFactory> */
    use HasFactory;
    protected $primaryKey = 'notificacion_id';
    protected $table = 'notificaciones';

    protected $fillable = [
        'cliente_id',
        'titulo',
        'mensaje',
        'tipo',
        'leida',
        'url_destino',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
