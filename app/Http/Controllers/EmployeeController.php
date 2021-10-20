<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function show(Employee $employee)
    {
        return view('employees.show', [
            'employee' => $employee,
            'jobs' => $employee->jobs,
        ]);
    }

    public function search(Request $request) {
        dd($request);
    }
}
