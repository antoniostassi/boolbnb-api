<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'title',
        'rooms',
        'beds',
        'bathrooms',
        'apartment_size',
        'address',
        'image',
        'is_visible',
        'user_id'
    ];

    public function user() : belongsTo
    {
        return $this->belongsTo(User::class); // Relation many apartments has one user.
    }

    public function visualizations() : hasMany {
        return $this->hasMany(Visualization::class); // Relation one apartmnent has many visualizations.
    }

    public function services() : belongsToMany {
        return $this->belongsToMany(Service::class); // Many to Many relation
    }
}
