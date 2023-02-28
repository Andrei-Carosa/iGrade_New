<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAdmin extends Model
{
    use HasFactory;
    protected $table ='grading_users';
    protected $primaryKey = 'grading_id';

    protected $hidden = [
        'grading_id',
        'p_id',
    ];
}
