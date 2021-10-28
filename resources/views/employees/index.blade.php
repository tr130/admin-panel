@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <ul>
                @foreach ($employees as $employee)
                <li>
                    <a href="{{ route('employees.show', $employee) }}">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                </li>
                @endforeach
            </ul>
            {{ $employees->links() }}
        </div>
    </div>
@endsection
