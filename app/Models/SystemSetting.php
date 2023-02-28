<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    protected $table ='systems_setting';
    protected $primaryKey = 'setting_id';

    protected $hidden = [
        'setting_id',
    ];

    public function sys_ay(){
        return $this->belongsTo(AcademicYear::class,'ay_id','ay_id')->select('ay_name');
    }
}
