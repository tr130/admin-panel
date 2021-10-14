<?php

namespace App\Models;

use App\Models\Company;
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
}
