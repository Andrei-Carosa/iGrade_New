<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iGradeImport extends Model
{
    use HasFactory;
    protected $table ='igrade_import';
    protected $primaryKey = 'import_id';

    protected $hidden = [
        // 'import_id',
    ];

    public function import_lms(){
        return $this->belongsTo(LmsPost::class,'post_id','post_id');
    }

    public function import_lms_submitted(){
        return $this->HasMany(LmsPostSubmission::class,'post_id','post_id');
    }

    public function getCategoryNameAttribute(){
        return $this->category==0?'LEC:CP':($this->category==1?'LEC:Quiz':($this->category==2?'LEC:Others':($this->category==3?'LEC:Exam':($this->category==6?'LAB:CP':($this->category==7?'LAB:Exercise':'LAB:Exam')))));

    }
}
