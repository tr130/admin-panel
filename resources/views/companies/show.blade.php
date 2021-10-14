@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <h2>{{ $company->name }} <a href="{{ $company->website }}">(link)</a></h2>
            <h3>Contact email: <a href="mailto:{{ $company->email }}">{{ $company->email }}</a></h3>
            <img src="{{ $company->logo }}" alt="logo" width="100" height="100" class="border-2">
            <hr>
            <h3>Employees</h3>
            <ul>
                @foreach ($employees as $employee)
                    <li>
                        <a href="{{ route('employees.show', $employee) }}">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <a class="p-2 m-2 bg-blue-600 rounded-md" href="{{ route('payrolls.create', $company) }}">Run Payroll</a>
            <h2 class="mt-2 font-bold">Previous Payrolls</h2>
            @foreach ($payrolls as $payroll)
                <a href="">{{ $payroll->tax_year }} - Month {{ $payroll->month }}</a>
            @endforeach
        </div>
    </div>
@endsection
