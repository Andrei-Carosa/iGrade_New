<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;
    protected $primaryKey = 'time_id';

    protected $hidden = [
        'time_id',
    ];
}
