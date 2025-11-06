<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPackageImage extends Model
{
    use HasFactory;

    protected $fillable = ['trip_package_id', 'image'];

    public function tripPackage()
    {
        return $this->belongsTo(TripPackage::class);
    }
}
