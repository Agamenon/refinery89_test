<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/** @var Route $router */
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
    return redirect()->route('department.index');
});
Route::resource('department',DepartmentController::class)->except(['edit']);
Route::put('department/{department}/user/{user}/link', [DepartmentController::class, 'linkWithUser'])->name('department.linkWithUser');
Route::put('department/{department}/user/{user}/unlink', [DepartmentController::class, 'unlinkWithUser'])->name('department.unlinkWithUser');
Route::put('department/{department}/link/{parentDepartment}', [DepartmentController::class, 'linkWithDepartment'])->name('department.linkWithDepartment');
Route::resource('user', UserController::class);
