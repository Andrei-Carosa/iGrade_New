<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsPostSubmission extends Model
{
    use HasFactory;
    protected $table ="lms_posts_submission";
    protected $primaryKey = 'submit_id';

    protected $hidden = [
        // 'post_id',
        'submit_id'
    ];

    public function stud_info()
    {
        return $this->belongsTo(Student::class,'stud_id','stud_id')->withDefault();
    }
}
