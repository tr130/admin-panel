<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class JobController extends Controller
{
    public function store(Request $request, Company $company)
    {
        //check if employee already employed by this company
        //check pension status
        $request->validate([
            'employee_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'annual_gross' => 'required|numeric',
            'contracted_hours' => 'required|numeric',
            'overtime_rate' => 'required|numeric',
            'pension_optout_date' => 'nullable|date',
        ]);
        $job = $company->jobs()->create($request->only(
            'employee_id',
            'start_date',
            'end_date',
            'annual_gross',
            'contracted_hours',
            'overtime_rate',
            'pension',
            'pension_optout_date'));
        $job->createYears();
        return back();
    }
}
