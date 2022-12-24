<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimeSheetActivityController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('role', RoleController::class);

Route::middleware('jwt.verify')
    ->resource('time-sheet-activity', TimeSheetActivityController::class);

Route::prefix('time-sheet-activity')
    ->middleware('jwt.verify')
    ->controller(TimeSheetActivityController::class)
    ->group(function () {
        Route::post('/approve/{id}', 'approve');
        Route::post('/reject/{id}', 'reject');
    });

Route::prefix('attendance')
    ->middleware('jwt.verify')
    ->controller(AttendanceController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/tap-in', 'tapIn');
        Route::post('/tap-out', 'tapOut');
        Route::post('/current-attendance', 'currentAttendance');
        Route::get('/{id}', 'show');
    });

Route::middleware('jwt.verify')
    ->resource('employee', UserController::class);

Route::prefix('employee')
    ->middleware('jwt.verify')
    ->controller(UserController::class)
    ->group(function () {
        Route::put('/reset-password/{id}', 'resetPassword');
    });


Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/register', 'store');
        Route::post('/login', 'login');
    });
