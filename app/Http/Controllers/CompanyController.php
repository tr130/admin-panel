<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all()->sortBy('name');

        return view('companies.index', [
            'companies' => $companies,
        ]);
    }

    public function show(Company $company)
    {

        $jobs = $company->jobs()->with(['employee'])->paginate();
        $payrolls = $company->payrolls()->paginate();
        return view('companies.show', [
            'company' => $company,
            'jobs' => $jobs,
            'payrolls' => $payrolls,
        ]);
    }
}
