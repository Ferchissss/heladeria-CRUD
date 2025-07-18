<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoIngrediente extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoIngredienteFactory> */
    use HasFactory;
    protected $table = 'producto_ingrediente';
    
    // No usamos $primaryKey autoincremental (es clave compuesta)
    public $incrementing = false;
    protected $primaryKey = ['producto_id', 'ingrediente_id'];

    protected $fillable = [
        'producto_id',
        'ingrediente_id',
        'es_default', // Si el ingrediente viene por defecto en el producto
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Relación con Ingrediente
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'ingrediente_id');
    }
}
