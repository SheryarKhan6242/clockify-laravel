<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];  
    use HasFactory;

    public function gender(){
        return $this->belongsTo(Gender::class, 'gen_id');
    }

    public function maritalStatus(){
        return $this->belongsTo(MaritalStatus::class, 'marital_status');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function shift(){
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function employeeType(){
        return $this->belongsTo(EmployeeType::class, 'emp_type');
    }

    public function workType(){
        return $this->belongsTo(EmployeeWorkingType::class, 'work_type');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
