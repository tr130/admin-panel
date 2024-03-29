<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::orderBy('last_name')->paginate(10);

        return view('employees.index', [
            'employees' => $employees,
        ]);
    }


    public function show(Employee $employee)
    {
        return view('employees.show', [
            'employee' => $employee,
            'jobs' => $employee->jobs()->with(['jobYears.payslips'])->paginate(),
        ]);
    }

    public function search(Request $request)
    {
        if($request->input()) {
            $q = $request->input("q");
            if($request->input('detail') === "true") {
                return new EmployeeResource(Employee::firstWhere('ni_number', $q));
            }
            return EmployeeResource::collection(Employee::where('first_name', 'ilike', "%{$q}%")->orWhere('last_name', 'ilike', "%{$q}%")->get());
        } else {
            return EmployeeResource::collection(Employee::all());
        }
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

    public function update(Request $request)
    {
        $splitParts = explode("/", $request->header('REFERER'));
        if ($request['id'] !== $splitParts[sizeof($splitParts)-1]) {
            // return an error
            return redirect($request->header('REFERER'))->with('fail', 'Unable to update employee details. Please try again.');
        }
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'email|max:250',
            'phone' => 'max:50',
            'date_of_birth' => 'required|date',
            'ni_number' => 'required|regex:/[A-Z]{2}\d{6}[A-Z]/',
        ]);
        $employee = Employee::findOrFail($request['id']);
        //if ni number has changed, validate it for uniqueness
        if ($request->ni_number !== $employee->ni_number) {
            $request->validate([
                'ni_number' => 'unique:employees',
            ]);
        }
        $employee->update($request->only(
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
        return redirect($request->header('REFERER'));
    }
}
