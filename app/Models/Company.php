<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
