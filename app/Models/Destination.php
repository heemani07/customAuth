<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
          protected $fillable = [
        'name',
        'description',
        'image',
        'category_id',
         'status',


    ];

public function categories()
{
    return $this->belongsToMany(Category::class);
}

}
