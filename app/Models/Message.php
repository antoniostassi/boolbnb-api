<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
        'content',
        'user_email',
        'firstname',
        'lastname',
        'apartment_id'
    ];

    public function apartment(){
        return $this->belongsTo(Apartment::class); // Relation one apartment to many messages
    }
}
