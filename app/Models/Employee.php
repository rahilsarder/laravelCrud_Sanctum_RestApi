<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'users_id', 'department_id', 'dutyTime_id'];



    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function department(){
      return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function dutyTime(){
        return $this->belongsTo(DutyTime::class, 'dutyTime_id','id');
    }
}
