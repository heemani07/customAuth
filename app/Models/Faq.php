<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    /**
     * The attributes that can be mass assigned.
     */
    protected $fillable = [
        'question',
        'answer',

    ];

    /**
     * Default attribute values.
     */
    protected $attributes = [

    ];

    /**
     * Accessor to show a formatted status badge (optional for blade).
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }
}
