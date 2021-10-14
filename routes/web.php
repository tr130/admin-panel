<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PayrollController;
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

Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
