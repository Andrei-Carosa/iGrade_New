<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iGradeLecture extends Model
{
    use HasFactory;
    protected $table ='igrade_lecture';
    protected $primaryKey = 'lecture_id';

    protected $hidden = [
        // 'import_id',
    ];

    public function stud_info_lec()
    {
        return $this->belongsTo(Student::class,'stud_id','stud_id')->select(['stud_id','fname','lname','mname']);
    }
}
