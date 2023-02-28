<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iGradeColumn extends Model
{
    use HasFactory;
    protected $table ='igrade_column';
    protected $primaryKey = 'col_id';

    protected $hidden = [
        // 'col_id',
    ];

    public function column_score()
    {
        return $this->hasMany(IgradeScores::class,'col_id','col_id')->select(['score_id','col_id','stud_id','score']);
    }
}
