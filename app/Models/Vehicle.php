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
        'description',
        'photo',
        'images',
        'rate_hour',
        'rate_day',
        'rate_week',
        'active'
    ];

    public function getCarNameAttribute()
    {
        return "{$this->make} {$this->model}";
    }
    public function rentals(){
        return $this->hasMany(Rental::class);
    }

    public function scopeAvailable($query, $start, $end)
    {
        return $query->whereDoesntHave('rentals', function($qq) use($start, $end) {
            $qq->whereIn('status', ['reserved', 'ongoing'])
            ->where(function($w) use($start, $end) {
                // Vehicles reserved or ongoing within the start and end range
                $w->whereBetween('rental_start', [$start, $end])
                    ->orWhereBetween('rental_end', [$start, $end])
                    ->orWhere(function($z) use($start, $end) {
                        // Vehicles that overlap the requested range
                        $z->where('rental_start', '<=', $start)
                        ->where('rental_end', '>=', $end);
                    });
            });
        });
    }


    protected $casts = [
    'images' => 'array'
    ];
}
