<?php

namespace App\Models;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'ni_number',
        'SL1',
        'SL2',
        'SL4',
        'SLPG',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }
}
