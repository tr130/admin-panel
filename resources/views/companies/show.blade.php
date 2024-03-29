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
            {{-- <img src="{{ asset('storage/placeholder.png') }}" alt="logo" width="100" height="100" class="border-2"> --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
  <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
</svg>
            <div class="flex flex-col m-2">
                <h2 class="text-4xl">{{ $company->name }}</h2>
                <div>
                    <a href="{{ $company->website }}"><i class="bi bi-globe2"></i></a>
                    <a href="mailto:{{ $company->email }}"><i class="bi bi-envelope"></i></a>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch flex-grow">
            <div class="sm:w-full md:w-1/2 p-6 md:p-3 border-b-4 sm:border-r-4">
                <div class="flex">
                    <h3 class="text-2xl">Employees</h3>
                    <button class="bg-green-500 text-white rounded-md px-2 py-1 mx-2 text-base font-medium hover:bg-green-600
                        focus:outline-none focus:ring-2 focus:ring-green-300" id="add_emp_btn">
                        <i class="bi bi-person-plus-fill"></i> New
                    </button>
                </div>
                <ul>
                    @foreach ($jobs as $job)
                    <li>
                        <a href="{{ route('employees.show', $job->employee) }}"><i class="bi bi-person-fill text-green-500"></i> {{ $job->employee->last_name }},
                            {{ $job->employee->first_name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="sm:w-full md:w-1/2 p-6 md:p-3 border-b-4">
                <div class="flex">
                    <h3 class="text-2xl">Payrolls</h3>
                    <a class="bg-green-500 text-white rounded-md px-2 py-1 mx-2 text-base font-medium hover:bg-green-600
                        focus:outline-none focus:ring-2 focus:ring-green-300" href="{{ route('payrolls.create', $company) }}"> Run
                        Payroll <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
                <ul>
                    @foreach ($payrolls as $payroll)
                    <li>
                        <a href="{{ route('payrolls.show', $payroll->id) }}"><i class="bi bi-calendar2-week-fill text-green-500"></i> <strong>{{ $payroll->tax_year }}</strong> - Month
                            {{ $payroll->month }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="add_emp_modal">
    <div class="relative top-20 mx-auto p-5 border w-4/5 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add new position</h3>
            <div class="mt-2 px-7 py-3">
                <form action="{{ route('employees.store') }}" id="employee_form" method="post">
                    @csrf
                    <div class="mb-2">
                        <input type="radio" name="emp_type" id="new_employee" value="new" onclick="empType(this);">
                        <label for="new_employee">New Employee</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" name="emp_type" id="existing_employee" value="existing"
                            onclick="empType(this);">
                        <label for="existing_employee">Existing Employee</label>
                    </div>
                    <div id="choose_employee" class="hidden mb-2">
                        <label for="emp_search">Choose employee:</label>
                        <input list="emp_datalist" name="employee" id="emp_search"
                            class="bg-gray-100 mb-2 border-2 p-1 rounded-lg" autocomplete="off">
                        <datalist id="emp_datalist">
                        </datalist>
                        <div class="bg-blue-500 text-white rounded-md p-2 text-base font-medium hover:bg-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-300 inline cursor-pointer" id="get_details">Get
                            details</div>
                    </div>
                    <input type="hidden" name="id" id="id">
                    <div class="mb-2">
                        <label for="first_name">First name:</label>
                        <input type="text" name="first_name" id="first_name" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="last_name">Last name:</label>
                        <input type="text" name="last_name" id="last_name" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="ni_number">NI number:</label>
                        <input type="text" name="ni_number" id="ni_number" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('ni_number') border-red-500 @enderror">
                        @error('ni_number')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('email') border-red-500 @enderror">
                        @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="phone">Phone:</label>
                        <input type="tel" name="phone" id="phone" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('phone') border-red-500 @enderror">
                        @error('phone')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value=""
                            class="bg-gray-100 border-2 p-1 rounded-lg emp_details @error('date_of_birth') border-red-500 @enderror">
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
                            <input type="checkbox" name="SL1" id="SL1" class="emp_details" value="true">
                            <label for="SL2">Plan 2:</label>
                            <input type="checkbox" name="SL2" id="SL2" class="emp_details" value="true">
                            <label for="SL4">Plan 4:</label>
                            <input type="checkbox" name="SL4" id="SL4" class="emp_details" value="true">
                            <label for="SLPG">Post Graduate:</label>
                            <input type="checkbox" name="SLPG" id="SLPG" class="emp_details" value="true">
                        </fieldset>
                    </div>
                    <button type="submit" id="get_employee_id" class="bg-blue-500 text-white rounded-md p-2 text-base font-medium hover:bg-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-300" id="add_emp_btn">Proceed</button>
                </form>
                <form action="{{ route('jobs.store', $company) }}" id="job_form" method="post" class="hidden">
                    @csrf
                    <input type="hidden" name="employee_id" id="employee_id">
                    <label for="start_date">Start date:</label>
                    <input type="date" name="start_date" id="start_date"><br>
                    <label for="end_date">End date (if applicable):</label>
                    <input type="date" name="end_date" id="end_date"><br>
                    <label for="annual_gross">Annual Gross:</label>
                    <input type="number" name="annual_gross" id="annual_gross" step="any"><br>
                    <label for="contracted_hours">Contracted Hours per Month:</label>
                    <input type="number" name="contracted_hours" id="contracted_hours" step="any"><br>
                    <label for="overtime_rate">Overtime Rate:</label>
                    <input type="number" name="overtime_rate" id="overtime_rate" step="any"><br>
                    <label for="pension">Pension:</label>
                    <input type="checkbox" name="pension" checked id="pension" onclick="pensionOptout(this);">
                    <span id="pension_optout" class="hidden">
                        <label for="pension_optout_date">Pension Optout Date:</label>
                        <input type="date" name="pension_optout_date" id="pension_optout_date">
                    </span>
                    <div class="items-center px-4 py-3">
                        <button type="submit" id="ok-btn"
                            class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Add position
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
<!--modal content-->
<script>
    const empType = function (radio) {
        if (radio.value === 'existing') {
            document.getElementById('choose_employee').classList = "";
            let form = document.getElementsByClassName('emp_details');
            for (let input of form) {
                input.disabled = true;
            }
        } else if (radio.value === 'new') {
            document.getElementById('choose_employee').classList = "hidden";
            let form = document.getElementsByClassName('emp_details');
            for (let input of form) {
                input.disabled = false;
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = "";
                }
            }
            document.getElementById('id').value = "";
            document.getElementById('emp_search').value = "";
        }
    }

    const pensionOptout = function (pension) {
        if (pension.checked === false) {
            document.getElementById('pension_optout').classList = "";
        } else {
            document.getElementById('pension_optout').classList = "hidden";
        }
    }

</script>
<script>
    let modal = document.getElementById("add_emp_modal");

    let btn = document.getElementById("add_emp_btn");

    // let button = document.getElementById("ok-btn");

    btn.onclick = function () {
        modal.style.display = "block";
    }
    // We want the modal to close when the OK button is clicked
    // button.onclick = function () {
    //     modal.style.display = "none";
    // }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    if (document.createElement("datalist").options) {
        $("#emp_search").on("input", function (e) {
            let val = $(this).val();
            if (val.length < 3) return;
            $.get("{{ route('employees.search') }}", {
                q: val,
                detail: false
            }, function (res) {
                let dataList = $("#emp_datalist");
                dataList.empty();
                if (res.data.length) {
                    for (let i = 0, len = res.data.length; i < len; i++) {
                        let opt = $(`<option></option>`).attr("data-value", res.data[i].id)
                            .attr(
                                "value",
                                `${res.data[i].first_name} ${res.data[i].last_name} (${res.data[i].ni_number})`
                                );
                        dataList.append(opt);
                    }
                }
            }, "json");
        });

        $("#get_details").on("click", function (e) {
            let emp = $('#emp_search').val();
            let nino = emp.match(/[A-Z]{2}\d{6}[A-Z]/);
            $.get("{{ route('employees.search') }}", {
                q: nino[0],
                detail: true
            }, function (res) {
                if (res.data) {
                    for (let property in res.data) {
                        if (res.data[property] === true) {
                            document.getElementById(property).checked = true;
                        } else if (res.data[property] === false) {
                            document.getElementById(property).checked = false;
                        } else {
                            document.getElementById(property).value = res.data[property];
                        }
                    }
                }
            }, "json");
        });
    }
    $("#employee_form").on("submit", function (e) {
            e.preventDefault();
            let empData;
            if (document.getElementById('new_employee').checked == true) {
                empData = {
                    _token: '{{ csrf_token() }}',
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    ni_number: $('#ni_number').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    date_of_birth: $('#date_of_birth').val(),
                    SL1: document.getElementById('SL1').checked,
                    SL2: document.getElementById('SL2').checked,
                    SL4: document.getElementById('SL4').checked,
                    SLPG: document.getElementById('SLPG').checked,
                };
            } else if (document.getElementById('existing_employee').checked == true) {
                empData = {
                    _token: '{{ csrf_token() }}',
                    id: $('#id').val(),
                };
            }
            let errorMessages = document.getElementsByClassName('error-message');
            for (let errorMessage of errorMessages) {
                errorMessage.textContent = "";
            }
            let errorInputs = document.getElementsByClassName('border-red-500');
            for (let errorInput of errorInputs) {
                errorInput.classList.remove('border-red-500');
            }
            $.ajax({
                type: "POST",
                url: "{{ route('employees.store') }}",
                data: empData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                document.getElementById('employee_id').value = data.id;
                document.getElementById('employee_form').classList.add('hidden');
                document.getElementById('job_form').classList.remove('hidden');
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 422) {
                    let errors = jqXHR.responseJSON.errors;
                    for (let error in errors) {
                        let errorMessage = document.createElement('div');
                        errorMessage.classList = ['text-red-500 mt-2 text-sm error-message'];
                        errorMessage.textContent = errors[error][0];
                        errorInput = document.getElementById(error);
                        errorInput.classList.add('border-red-500');
                        errorInput.parentElement.appendChild(errorMessage);
                    }
                }
            });
        });
    })

</script>
@endsection
