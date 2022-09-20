<?php

use Inertia\Inertia;
use App\Mail\EmployeeCheckMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReportController;

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

Route::redirect('/', 'login');



// Reports 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {






    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/report/create', [ReportController::class, 'create'])->name('create-report');
    Route::post('/reports', [ReportController::class, 'store'])->name('store-report');
    Route::get('/report/{report}/edit', [ReportController::class, 'edit'])->name('edit-report');
    Route::put('/report/{report}', [ReportController::class, 'update'])->name('update-report');
    Route::get('/reports/filter/{week_no}', [ReportController::class, 'filter'])->name('reports-filter');


    Route::get('/weeks', [WeekController::class, 'index'])->name('weeks');
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('create-drivers');
    Route::post('/drivers/store', [DriverController::class, 'store'])->name('store-drivers');
    Route::get('/drivers/{drivers}/edit', [DriverController::class, 'edit'])->name('edit-drivers');
    Route::put('/drivers/{drivers}', [DriverController::class, 'update'])->name('update-drivers');
    // Route for email
    Route::get('/email', function () {
        return new EmployeeCheckMail();
    });

    Route::get('/users', function () {
        return Inertia::render('Users');
    })->name('users');
});
