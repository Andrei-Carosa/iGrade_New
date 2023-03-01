<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleBlocking extends Model
{
    use HasFactory;
    protected $table ="schedules_blocking";
    protected $primaryKey = 'id';

    protected $hidden = [
        'id',
        'block_id',
        'sched_id'
    ];

    public function block(){
        return $this->belongsTo(Block::class,'block_id','block_id')->select(['block_id','block_name']);
    }
}
