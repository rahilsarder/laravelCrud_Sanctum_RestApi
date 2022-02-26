<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'users_id', 'department_id', 'dutyTime_id'];



    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function dutyTime()
    {
        return $this->belongsTo(DutyTime::class, 'dutyTime_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    // static function getAllEmployees()
    // {
    //     $employee = Employee::all();
    //     $employee->users_id = [User::find($employee->users_id)->toJson()];
    //     $employee->department_id = [Department::find($employee->department_id)->toJson()];
    //     $employee->dutyTime_id = [DutyTime::find($employee->dutyTime_id)->toJson()];

    //     return $employee;
    // }
}
