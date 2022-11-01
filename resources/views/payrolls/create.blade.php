@extends('layouts.app')

@section('content')
        <div class="w-full md:w-3/4 lg:w-1/2 bg-white p-6">
            <h2>Run payroll for <a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a></h2>
            <hr>
            @if (Session::has('fail'))
        <div class="text-red-500 mt-2 text-lg">
            {{Session::get('fail')}}
        </div>
    @endif
                <form action="{{ route('payrolls.store', $company) }}" method="POST" class="p-6">
                @csrf
                <div class="mb-2">
                    <label for="tax_year">Year: </label>
                    <input type="number" name="tax_year" id="tax_year" min="2011" max="2022" value="2022"
                    class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('tax_year') border-red-500 @enderror" style="width:6rem">
                    @error('tax_year')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="month">Month: </label>
                    <input type="number" name="month" id="month" min="1" max="12"
                    class="bg-gray-100 border-2 p-1 rounded-lg @error('tax_year') border-red-500 @enderror" style="width:6rem">
                    @error('month')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-2">
                @foreach ($jobs as $job)
                    <li>
                        <div class="flex justify-between">
                            <div style="align-self:center">
                                <a href="{{ route('employees.show', $job->employee) }}">{{ $job->employee->first_name }} {{ $job->employee->last_name }}</a>
                            </div>

                            <div>
                                <label for="hours-{{ $job->id }}">Hours:</label>
                        <input type="number" name="{{ $job->id }}" id="hours-{{ $job->id }}"
                        value="{{ $job->contracted_hours }}" style="width:6rem" class="bg-gray-100 border-2 p-1 rounded-lg">
                            </div>
                        </div>

                    </li>
                @endforeach
                </div>
                <button class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300" type="submit">Run payroll</button>
                </form>

        </div>
@endsection
