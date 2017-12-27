<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $fillable = [
    	'idingreso',
    	'idarticulo',
    	'cantidad',
    	'precio_compra',
    	'precio_venta'
    ];
}
