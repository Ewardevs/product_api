<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['cliente', 'productos'];

    protected $casts = [
        'productos' => 'array', // Esto es importante para que Laravel convierta automáticamente la columna 'productos' en un array al guardar y recuperar los datos.
    ];
    protected $hidden = [

        'updated_at'
    ];
}
