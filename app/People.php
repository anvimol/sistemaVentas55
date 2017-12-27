<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = [
    	'type_person', 'name', 'type_document', 'num_document',
    	'direction', 'phone', 'email'
    ];
}
