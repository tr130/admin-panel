<?php

namespace App\Models;

use App\Models\JobYear;
use App\Models\Payroll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payslip extends Model
{
    use HasFactory;

    public function jobYear()
    {
        return $this->belongsTo(JobYear::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
