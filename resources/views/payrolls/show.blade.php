@extends('layouts.app')

@section('content')
<div class="bg-white w-full flex flex-col">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="flex bg-green-100 w-100 p-4">
        <div class="flex flex-col m-2">
            <h2 class="text-4xl">Payroll - {{ $payroll->tax_year }}, Month {{ $payroll->month }}</h2>
            <div class="job-payslips">
                <form action="{{ route('payrolls.form') }}" method="post">
                    @csrf
                    <label for="payroll_id">View payroll:</label>
                    <select name="id" id="payroll_id">
                        @foreach ($payroll->company->payrolls->sortBy('tax_year')->sortBy('month') as $payrollOption)
                            <option value="{{ $payrollOption->id }}">{{ $payrollOption->tax_year }} - Month {{ $payrollOption->month }}</option>
                        @endforeach
                    </select>
                    <button type="submit">View Payroll</button>
                </form>
            </div>
            <div>
                <a href="{{route('companies.show', $payroll->company)}}">{{ $payroll->company->name }}</a>
            </div>
        </div>
    </div>
    <div class="flex items-stretch flex-grow">
        <div class="w-full p-3">
            <h3 class="text-2xl">Payslips</h3>
            <ul>
                @foreach ($payslips as $payslip)
                <li class="my-1">
                    <a href="{{ route('employees.show', $payslip->jobYear->job->employee) }}"><i class="bi bi-person-fill text-green-500"></i> {{ $payslip->jobYear->job->employee->last_name }},
                        {{ $payslip->jobYear->job->employee->first_name }} ({{ $payslip->jobYear->job->employee->ni_number }}) - £{{ $payslip->net_pay }}</a>
                    <form action="{{ route('payslips.show') }}" method="post" class="inline">
                        @csrf
                        <input type="hidden" name="id" id="payslip_id" value="{{ $payslip->id }}">
                        <button type="submit" class="bg-green-500 text-white rounded-md px-2 py-1 mx-2 text-base font-medium hover:bg-green-600
                            focus:outline-none focus:ring-2 focus:ring-green-300"> <i class="bi bi-card-list"></i> View Payslip
                        </button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
