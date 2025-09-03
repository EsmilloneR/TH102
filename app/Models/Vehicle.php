<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'make',
        'model',
        'year',
        'licensed_number',
        'color',
        'transmission',
        'seats',
        'rate_hour',
        'rate_day',
        'rate_week',
        'active'
    ];

    public function rentals(){
        return $this->hasMany(Rental::class);
    }

    public function scopeAvailable($query, $start, $end){
        return $query->whereDoesntHave('rentals', function($qq) use($start, $end){
            $qq->whereIn('status', ['reserved', 'ongoing'])->where(function($w) use($start, $end){
                $w->whereBetween('rental_start', [$start, $end])->orBetween('rental_end', [$start, $end])->orBetween(function($z) use($start, $end){
                    $z->where('start_at', '<=', $start)->where('end_at', '>=', $end);
                });
            });
        });
    }
}
