@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-2/5 bg-white p-6 rounded-lg">
            <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
            <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
            <p>DOB: {{ Carbon\Carbon::parse($employee->date_of_birth)->format('d/m/Y') }}</p>
        </div>
        <div class="w-3/5 bg-gray-200 p-6 rounded-lg">
            @foreach ($jobs as $job)
                <x-job :job="$job"/>
            @endforeach
        </div>
    </div>
@endsection
