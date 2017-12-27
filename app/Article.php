<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $fillable = [
    	'category_id', 'code', 'name', 'stock', 'description',
    	'image', 'status',
    ];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}
