<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function store(Request $request, Company $company)
    {
        if($request->emp_type === 'new') {
            //create new employee
        } elseif($request->emp_type === 'existing') {
            $employee = Employee::FindOrFail($request->id);
        }
        dd($request);
        //$job->createYears();
    }
}
