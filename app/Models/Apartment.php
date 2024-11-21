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

    public function user(){
        return $this->belongsTo(User::class); // Relation one user to many apartments
    }

    public function messages(){
        return $this->hasMany(Message::class); // Relation many messages to one apartment
    }

    public function promotions(){
        return $this->hasMany(Promotion::class); //relation many to many with promotions
    }
}
