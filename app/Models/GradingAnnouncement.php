<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingAnnouncement extends Model
{
    use HasFactory;
    protected $table ='grading_announcement';
    protected $primaryKey = 'announce_id';

    protected $fillable =[
        'p_id','title','message','expected_date','created_at','updated_at','sem_id','ay_id'
    ];
}
