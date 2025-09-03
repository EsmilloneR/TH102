<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'rental_start',
        'rental_end',
        'pickup_location',
        'dropoff_location',
        'trip_type',
        'fuel_level_out',
        'fuel_level_in',
        'base_amount',
        'deposit',
        'extra_charges',
        'penalties',
        'total',
        'status',
        'agreement_no'
    ];
    protected $casts = [
        'start_at'=>'datetime',
        'end_at'=>'datetime'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function vehicle(){
         return $this->belongsTo(Vehicle::class);
    }
    public function inspections(){
         return $this->hasMany(Inspection::class);
    }
    public function payments(){
         return $this->hasMany(Payment::class);
    }
}
