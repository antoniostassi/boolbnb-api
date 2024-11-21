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

    protected $with = [ // To include on Apartment::get(), table related ( called with function names ).
        'user',
        'visualizations',
        'services',
        'messages',
        'promotions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Relation many apartments has one user.
    }

    public function visualizations()
    {
        return $this->hasMany(Visualization::class); // Relation one apartmnent has many visualizations.
    }

    public function services()
    {
        return $this->belongsToMany(Service::class); // Many to Many relation
    }

    public function messages()
    {
        return $this->hasMany(Message::class); // Relation many messages to one apartment
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class); //relation many to many with promotions
    }
}
