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

    public function store(Request $request) {
        if(isset($request->id)) {
            return response()->json(['id' => $request->id]);
        }
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'email|max:250',
            'phone' => 'max:50',
            'date_of_birth' => 'required|date',
            'ni_number' => 'required|regex:/[A-Z]{2}\d{6}[A-Z]/|unique:employees',
        ]);
        $employee = Employee::create($request->only(
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
        ));
        return response()->json(['id' => $employee->id]);
    }
}
