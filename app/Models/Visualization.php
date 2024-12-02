<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visualization extends Model
{
    //
    public $timestamps = false; // not to use timestamps

    protected $fillable = ['apartment_id', 'ip_address', 'visit_date'];

    protected $hidden = ['id', 'apartment_id', 'ip_address'];

    public function apartment() : belongsTo
    {
        return $this->belongsTo(Apartment::class); // Relation many statistics to one apartment
    }
}
