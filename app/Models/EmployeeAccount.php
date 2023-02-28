<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class EmployeeAccount extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasFactory;

    protected $table ='employees_account';
    protected $primaryKey = 'account_id';

    protected $hidden = [
        'account_id',
        'password',
        'remember_token',
    ];

    public function admin_account(){
        return $this->hasOne(SystemAdmin::class,'p_id','p_id');
    }

    public function getAccountTypeAttribute(){
        return ($this->is_shs == 0 ? 'College':'SHS').' Faculty';
    }

    public function emp_info(){
        return $this->belongsTo(Employee::class,'p_id','p_id')->select(['p_id','fname','lname']);
    }

}
