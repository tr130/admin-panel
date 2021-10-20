@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
        <h2>{{ $company->name }} <a href="{{ $company->website }}">(link)</a></h2>
        <h3>Contact email: <a href="mailto:{{ $company->email }}">{{ $company->email }}</a></h3>
        <img src="{{ $company->logo }}" alt="logo" width="100" height="100" class="border-2">
        <hr>
        <h3>Employees</h3>
        <div class="mx-auto">
            <button class="bg-blue-500 text-white rounded-md p-2 text-base font-medium hover:bg-blue-600
                focus:outline-none focus:ring-2 focus:ring-blue-300" id="add_emp_btn">
                Add position
            </button>
        </div>
        <ul>
            @foreach ($employees as $employee)
            <li>
                <a href="{{ route('employees.show', $employee) }}">{{ $employee->first_name }}
                    {{ $employee->last_name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="w-4/12 bg-white p-6 rounded-lg">
        <a class="bg-blue-500 text-white rounded-md p-2 text-base font-medium hover:bg-blue-600
            focus:outline-none focus:ring-2 focus:ring-blue-300" href="{{ route('payrolls.create', $company) }}">Run
            Payroll</a>
        <h2 class="mt-2 font-bold">Previous Payrolls</h2>
        @foreach ($payrolls as $payroll)
        <a href="">{{ $payroll->tax_year }} - Month {{ $payroll->month }}</a>
        @endforeach
    </div>
</div>
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="add_emp_modal">
    <div class="relative top-20 mx-auto p-5 border w-4/5 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add new position</h3>
            <div class="mt-2 px-7 py-3">
                <form action="{{ route('jobs.store', $company) }}" id="job_form" method="post">
                    @csrf
                    <input type="radio" name="emp_type" id="new_employee" value="new" onclick="empType(this);">
                    <label for="new_employee">New Employee</label><br>
                    <input type="radio" name="emp_type" id="existing_employee" value="existing" onclick="empType(this);">
                    <label for="existing_employee">Existing Employee</label>
                    <div id="choose_employee" class="hidden">
                        <label for="emp_search">Choose employee:</label>
                        <input list="emp_datalist" name="employee" id="emp_search" autocomplete="off">
                        <datalist id="emp_datalist">
                        </datalist>
                        <div class="bg-blue-500 text-white rounded-md p-2 text-base font-medium hover:bg-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-300 inline cursor-pointer" id="get_details">Get details</div>
                    </div>
                    <br>
                    <input type="hidden" name="id" id="id">
                    <label for="first_name">First name:</label>
                    <input type="text" name="first_name" id="first_name" value="" class="emp_details"><br>
                    <label for="last_name">Last name:</label>
                    <input type="text" name="last_name" id="last_name" value="" class="emp_details"><br>
                    <label for="ni_number">NI Number:</label>
                    <input type="text" name="ni_number" id="ni_number" class="emp_details"><br>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="emp_details"><br>
                    <label for="phone">Phone:</label>
                    <input type="tel" name="phone" id="phone" class="emp_details"><br>
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="emp_details">
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
                    <hr>
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
</div>
<!--modal content-->
<script>
    const empType = function(radio) {
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

    const pensionOptout = function(pension) {
        console.log(pension.checked)
        if (pension.checked === false) {
            document.getElementById('pension_optout').classList="";
        } else {
            document.getElementById('pension_optout').classList="hidden";
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
<script
src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

	if(document.createElement("datalist").options) {

		$("#emp_search").on("input", function(e) {
			let val = $(this).val();
			if(val.length < 3) return;
			$.get("{{ route('employees.search') }}", {q:val, detail:false}, function(res) {
				let dataList = $("#emp_datalist");
				dataList.empty();
				if(res.data.length) {
					for(let i=0, len=res.data.length; i<len; i++) {
						let opt = $(`<option></option>`).attr("data-value", res.data[i].id).attr(
                            "value", `${res.data[i].first_name} ${res.data[i].last_name} (${res.data[i].ni_number})`);
						dataList.append(opt);
					}
				}
			},"json");
		});

        $("#get_details").on("click", function(e) {
            let emp = $('#emp_search').val();
            let nino = emp.match(/[A-Z]{2}\d{6}[A-Z]/);
            $.get("{{ route('employees.search') }}", {q:nino[0], detail:true}, function(res) {
                if (res.data) {
                    for(let property in res.data) {
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

})
</script>
@endsection
