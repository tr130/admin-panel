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
                        <a href="">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
