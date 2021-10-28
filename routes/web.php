<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
Route::get('/payrolls/{company}', [PayrollController::class, 'create'])->name('payrolls.create');
Route::post('/payrolls/{company}', [PayrollController::class, 'store'])->name('payrolls.store');
Route::get('/payslips/show/{payslip}', [PayslipController::class, 'show'])->name('payslips.show');
Route::get('/payslips/pdf/{payslip}', [PayslipController::class, 'pdf'])->name('payslips.pdf');
Route::post('/jobs/{company}', [JobController::class, 'store'])->name('jobs.store');
Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employees');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/show/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/search', function(Request $request) {
    if($request->input()) {
        $q = $request->input("q");
        if($request->input('detail') === "true") {
            return new EmployeeResource(Employee::firstWhere('ni_number', $q));
        }
        return EmployeeResource::collection(Employee::where('first_name', 'ilike', "%{$q}%")->orWhere('last_name', 'ilike', "%{$q}%")->get());
    } else {
        return EmployeeResource::collection(Employee::all());
    }
})->name('employees.search');
// Route::post('/employees/search', [EmployeeController::class, 'search']);
