<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payslip extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
