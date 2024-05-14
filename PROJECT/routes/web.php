<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\EmployeeFamilyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix'=>'api','as'=>'api'], function() {

    Route::group(['prefix'=>'employee','as'=>'employee'], function() {
        Route::get('/', [EmployeeController::class, 'GetData']);
        Route::post('create', [EmployeeController::class, 'Create']);
        Route::post('update', [EmployeeController::class, 'Update']);
        Route::delete('delete', [EmployeeController::class, 'Delete']);

        Route::group(['prefix'=>'profile','as'=>'profile'], function() {
            Route::get('/', [EmployeeProfileController::class, 'GetData']);
            Route::post('create', [EmployeeProfileController::class, 'Create']);
            Route::post('update', [EmployeeProfileController::class, 'Update']);
            Route::delete('delete', [EmployeeProfileController::class, 'Delete']);
        });

        Route::group(['prefix'=>'education','as'=>'education'], function() {
            Route::get('/', [EducationController::class, 'GetData']);
            Route::post('create', [EducationController::class, 'Create']);
            Route::post('update', [EducationController::class, 'Update']);
            Route::delete('delete', [EducationController::class, 'Delete']);
        });

        Route::group(['prefix'=>'family','as'=>'family'], function() {
            Route::get('/', [EmployeeFamilyController::class, 'GetData']);
            Route::post('create', [EmployeeFamilyController::class, 'Create']);
            Route::post('update', [EmployeeFamilyController::class, 'Update']);
            Route::delete('delete', [EmployeeFamilyController::class, 'Delete']);
        });

    });
});
