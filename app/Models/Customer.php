<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'address',
    'nationality',
    'id_type',
    'id_number'
];

    public function rentals(){
         return $this->hasMany(Rental::class);
    }
    public function getNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
