<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;
    protected $primaryKey = 'producto_id';
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'precio_base',
        'imagen_url',
        'disponible',
        'es_personalizado',
        'calorias',
        'tiempo_preparacion',
    ];

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación muchos a muchos con Ingredientes (para personalización)
    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'producto_ingrediente',
            'producto_id',
            'ingrediente_id'
        )->withPivot('es_default');
    }
}
