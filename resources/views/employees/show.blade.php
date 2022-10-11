@extends('layouts.app')

@section('content')
<div class="bg-white w-full flex flex-col">
            @if (Session::has('fail'))
            <div class="bg-red-100 text-red-700 px-4 py-3 relative" id="failAlert" role="alert">
  <strong class="font-bold">Error: </strong>
  <span class="block sm:inline">{{Session::get('fail')}}</span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <i id="dismissAlert" role="button" class="bi bi-x-lg"></i>
  </span>
</div>
@elseif ($errors->any())
<div class="bg-red-100 text-red-700 px-4 py-3 relative" id="failAlert" role="alert">
  <strong class="font-bold">Error: </strong>
  <span class="block sm:inline"><ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul></span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <i id="dismissAlert" role="button" class="bi bi-x-lg"></i>
  </span>
</div>
    @endif
    <div class="flex bg-green-100 w-100 p-4">
        <div class="flex flex-col m-2">
            <h2 class="text-4xl">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
            <div>
                <a href="tel:{{ $employee->phone }}"><i class="bi bi-telephone"></i></a>
                <a href="mailto:{{ $employee->email }}"><i class="bi bi-envelope"></i></a>
            </div>
        </div>
    </div>
        <div class="flex items-stretch flex-grow">
            <div class="w-1/2 p-3 border-r-4">
                <div class="flex flex-col">
                    <div>
                        <h3 class="text-2xl inline">Details </h3>
                        <button id="editDetails"><i class="bi bi-pencil-square text-green-500"></i></button>
                    </div>

                    <form action="{{ route('employees.update') }}" id="employee_form" method="post">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $employee->id }}">
                        <div class="mb-2">
                            <label for="first_name">First name:</label>
                            <input type="text" name="first_name" id="first_name" disabled value="{{ $employee->first_name }}"
                                class="p-1 emp_details @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="last_name">Last name:</label>
                            <input type="text" name="last_name" id="last_name" disabled value="{{ $employee->last_name }}"
                                class="p-1 emp_details @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="ni_number">NI number:</label>
                            <input type="text" name="ni_number" id="ni_number" disabled value="{{ $employee->ni_number }}"
                                class="p-1 emp_details @error('ni_number') border-red-500 @enderror">
                            @error('ni_number')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" disabled value="{{ $employee->email }}"
                                class="p-1 emp_details @error('email') border-red-500 @enderror">
                            @error('email')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="phone">Phone:</label>
                            <input type="tel" name="phone" id="phone" disabled value="{{ $employee->phone }}"
                                class="p-1 emp_details @error('phone') border-red-500 @enderror">
                            @error('phone')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="date_of_birth">Date of Birth:</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" disabled value="{{ Carbon\Carbon::parse($employee->date_of_birth)->format('Y-m-d')}}"
                                class="p-1 emp_details @error('date_of_birth') border-red-500 @enderror">
                            @error('date_of_birth')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <fieldset>
                                <legend>Student Loans Plans</legend>
                                <label for="SL1">Plan 1:</label>
                                <input type="checkbox" name="SL1" id="SL1" class="emp_details" disabled value="true" @if ($employee->SL1) checked @endif>
                                <label for="SL2">Plan 2:</label>
                                <input type="checkbox" name="SL2" id="SL2" class="emp_details" disabled value="true" @if ($employee->SL2) checked @endif>
                                <label for="SL4">Plan 4:</label>
                                <input type="checkbox" name="SL4" id="SL4" class="emp_details" disabled value="true" @if ($employee->SL4) checked @endif>
                                <label for="SLPG">Post Graduate:</label>
                                <input type="checkbox" name="SLPG" id="SLPG" class="emp_details" disabled value="true" @if ($employee->SLPG) checked @endif>
                            </fieldset>
                        </div>
                        <button type="submit" id="update_employee" class="hidden bg-green-500 text-white rounded-md p-2 text-base font-medium hover:bg-green-600
                        focus:outline-none focus:ring-2 focus:ring-blue-300" id="add_emp_btn">Update</button>
                    </form>
                </div>
            </div>
            <div class="w-1/2 p-3">
                <div class="flex flex-col">
                    <h3 class="text-2xl mb-2">Positions</h3>
            @foreach ($jobs as $job)
                <x-job :job="$job"/>
            @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    const editBtn = document.getElementById('editDetails');
    const updateBtn = document.getElementById('update_employee');
    let formActive = false;
    let form = document.getElementsByClassName('emp_details');
    editBtn.addEventListener('click', () => {
        formActive = !formActive;
        if (formActive) {
            for (let input of form) {
                input.removeAttribute('disabled');
                input.classList.add('bg-green-100', 'rounded-lg');
            }
            updateBtn.classList.remove('hidden');
        } else {
            for (let input of form) {
                input.setAttribute('disabled', 'true');
                input.classList.remove('bg-green-100', 'rounded-lg');
            }
            updateBtn.classList.add('hidden');
        }
    })

    const dismissAlert = document.getElementById('dismissAlert');
    const failAlert = document.getElementById('failAlert');

    if (dismissAlert) {
        dismissAlert.addEventListener('click', () => {
            failAlert.classList.add('hidden');
        })
    }

</script>
@endsection
