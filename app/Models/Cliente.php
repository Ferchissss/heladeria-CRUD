<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'password_hash',
        'activo',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }

    public function fidelizacion()
    {
        return $this->hasOne(Fidelizacion::class, 'cliente_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'cliente_id');
    }
}
