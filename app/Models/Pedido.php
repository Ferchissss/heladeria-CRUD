<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;
    protected $primaryKey = 'pedido_id';
    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id',
        'estado',
        'total',
        'direccion_entrega',
        'metodo_pago',
        'notas',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con DetallePedidos
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}
