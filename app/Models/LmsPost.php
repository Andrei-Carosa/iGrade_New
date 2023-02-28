<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsPost extends Model
{
    use HasFactory;
    protected $table ="lms_posts";
    protected $primaryKey = 'post_id';

    protected $hidden = [
        // 'post_id',
    ];

    protected $casts = [
        'posted_at' => 'datetime:Y-m-d',
    ];

    public function submitted_activity(){
        return $this->hasMany(ScheduleSubmittedActivity::class,'post_id','post_id')->select(['submit_id','post_id','stud_id','score','hps']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
