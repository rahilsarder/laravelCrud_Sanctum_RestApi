<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\Department;

class DutyTime extends Model
{
    use HasFactory;
    protected $fillable = ['start_time', 'end_time','name'];

    public function employee()
    {
      return $this->hasMany(Employee::class, 'dutyTime_id', 'id');
    }

}
