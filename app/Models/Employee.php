<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'p_id';

    protected $hidden = [
        'p_id',
    ];

    public function getFullnameAttribute(){
        return ucwords(strtolower($this->fname).' '.strtolower($this->lname));
    }
}
