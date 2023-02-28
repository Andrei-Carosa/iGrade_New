<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iGradeTerm extends Model
{
    use HasFactory;
    protected $table ='igrade_term';
    protected $primaryKey = 'term_id';

    protected $hidden = [
        // 'term_id',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
