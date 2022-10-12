<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function() {
    Route::get('/', [CompanyController::class, 'index'])->name('home');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
    Route::post('/payrolls/form/', [PayrollController::class, 'form'])->name('payrolls.form');
    Route::get('/payrolls/show/{payroll}', [PayrollController::class, 'show'])->name('payrolls.show');
    Route::get('/payrolls/{company}', [PayrollController::class, 'create'])->name('payrolls.create');
    Route::post('/payrolls/{company}', [PayrollController::class, 'store'])->name('payrolls.store');
    Route::post('/payslips/show/', [PayslipController::class, 'show'])->name('payslips.show');
    Route::get('/payslips/pdf/{payslip}', [PayslipController::class, 'pdf'])->name('payslips.pdf');
    Route::post('/jobs/{company}', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/update', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employees/show/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');
});

