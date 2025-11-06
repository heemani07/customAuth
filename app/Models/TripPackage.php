<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'category_id',
        'title',
        'description',
        'inclusions',
        'overview',
        'terms_and_conditions',
        'itinerary',
        'status',
    ];

    protected $casts = [
        'inclusions' => 'array',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(TripPackageImage::class);
    }
}
