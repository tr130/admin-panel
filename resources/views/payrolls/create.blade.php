@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <h2>Run payroll for {{ $company->name }} <a href="{{ $company->website }}">(link)</a></h2>
            <hr>
            <h3>Employees</h3>
            <ul>
                <form action="{{ route('payrolls.store', $company) }}" method="POST">
                @csrf
                <label for="tax_year">Year: </label>
                <input type="number" name="tax_year" id="tax_year" min="2011" max="2021" value="2021">
                <label for="month">Month: </label>
                <input type="number" name="month" id="month" min="1" max="12">
                @foreach ($jobs as $job)
                    <li>
                        <a href="{{ route('employees.show', $job->employee) }}">{{ $job->employee->first_name }} {{ $job->employee->last_name }}</a>
                        <input type="number" name="{{ $job->id }}" id="hours={{ $job->id }}" value="{{ $job->contracted_hours }}">
                    </li>
                @endforeach
                <button type="submit">Run payroll</button>
                </form>
            </ul>
        </div>
    </div>
@endsection
