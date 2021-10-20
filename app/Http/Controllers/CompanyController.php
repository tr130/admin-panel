<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        //$companies = Company::select('name')->get();
        $companies = Company::all();

        return view('companies.index', [
            'companies' => $companies,
        ]);
    }

    public function show(Company $company)
    {

        //dd($company->employees());
        $employees = $company->employees()->paginate();
        $payrolls = $company->payrolls()->paginate();
        $allEmployees = Employee::all();
        return view('companies.show', [
            'company' => $company,
            'employees' => $employees,
            'payrolls' => $payrolls,
            'all_employees' => $allEmployees,
        ]);
    }
}
