<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSection extends Model
{
    use HasFactory;
    protected $table ="schedules_section";
    protected $primaryKey = 'ss_id';
    protected $hidden = [
        'ss_id',
    ];

    public function sched_section(){
        return $this->belongsTo(Section::class,'section_id','section_id')->withDefault(['name' => ' -/-']);
    }
}
