<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = [
        'title',
        'image'
    ];

    public function apartments() : belongsToMany {
        return $this->belongsToMany(Apartment::class); // Many to Many relation
    }
}
