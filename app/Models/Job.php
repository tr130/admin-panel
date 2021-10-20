<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\JobYear;
use App\Models\Payslip;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function payslips() {
        return $this->hasMany(Payslip::class);
    }

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function jobYears()
    {
        return $this->hasMany(JobYear::class);
    }

    public function createYears() {
        $start_date = Carbon::parse($this->start_date);
        if($start_date->month <= 3 || ($start_date->month === 4 && $start_date->day <= 5)) {
            $from = $start_date->year - 1;
        } else {
            $from = $start_date->year;
        }
        for ($i = $from; $i <= now()->year; $i++) {
            $year = new JobYear;
            $year->job_id = $this->id;
            $year->tax_year = $i;
            $year->save();
        }
    }
}
