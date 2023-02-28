<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iGradeScores extends Model
{
    use HasFactory;
    protected $table ='igrade_scores';
    protected $primaryKey = 'score_id';

    protected $hidden = [
        'score_id',
    ];
}
