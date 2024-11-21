<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visualization extends Model
{
    //
    const CREATED_AT = 'visit_date';

    protected $fillable = [
        'apartment_id',
        'ip_address',
        'visit_date'
    ];

    public function apartment() : belongsTo
    {
        return $this->belongsTo(Apartment::class); // Relation many statistics to one apartment
    }
}
