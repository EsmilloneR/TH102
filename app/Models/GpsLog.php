<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsLog extends Model
{
    protected $fillable = ['vehicle_id', 'latitude', 'longitude', 'speed'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
