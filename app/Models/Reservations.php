<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Section;

class Reservations extends Model
{
    protected $fillable = [
        'user_id',
        'section_id',
        'date',
        'time_slot',
        'purpose',
        'resource_details',
        'usage_details',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}