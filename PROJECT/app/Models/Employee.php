<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\EmployeeProfile;
use App\Models\EmployeeFamily;
use App\Models\Education;

class Employee extends Model
{
    protected $table = 'employee';

    public function profile()
    {
        return $this->hasOne(EmployeeProfile::class, 'employee_id');
    }

    public function family()
    {
        return $this->hasMany(EmployeeFamily::class, 'employee_id');
    }

    public function education()
    {
        return $this->hasMany(Education::class, 'employee_id');
    }
}
