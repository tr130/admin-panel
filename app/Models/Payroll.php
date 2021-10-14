<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Payslip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_year',
        'month',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

}
