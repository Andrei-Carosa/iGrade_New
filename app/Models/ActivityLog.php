<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table ='grading_activity_log';
    protected $primaryKey = 'log_id';

    protected $hidden = [
        'log_id',
    ];

    protected $fillable = [
        'p_id',
        'sched_id',
        'status',
        'file_token'
    ];

    public function log_faculty(){
        return $this->belongsTo(Employee::class,'p_id','p_id');
    }

    public function log_sched(){
        return $this->belongsTo(Schedule::class,'sched_id','sched_id');
    }
}
