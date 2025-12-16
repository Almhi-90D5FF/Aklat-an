<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'code','name','email','telephone','description','resources'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
