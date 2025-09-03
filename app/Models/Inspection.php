<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    protected $fillable = [
        'rental_id',
        'type',
        'fuel_level',
        'odometer',
        'condition_notes',
        'photos'
    ];

    protected $casts = [
        'photos'=>'array'
    ];

    public function rental(){
        return $this->belongsTo(Rental::class);
    }

    
}
