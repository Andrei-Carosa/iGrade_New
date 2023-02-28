<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $primaryKey = 'program_id';

    protected $hidden = [
        'program_id',
    ];

    public function prog_college(){
        return $this->belongsTo(College::class,'college_id','college_id');
    }
}
