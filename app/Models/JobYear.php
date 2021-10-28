<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Payslip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobYear extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }
}
