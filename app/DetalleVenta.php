<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [
    	'idventa',
    	'idarticulo',
    	'cantidad',
    	'precio_venta',
    	'descuento'
    ];
}
