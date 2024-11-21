<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_time'
    ];

    public function apartments(){
        return $this->hasMany(Apartment::class); // relation many to many with apartments
    }
}
