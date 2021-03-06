<?php

use App\Http\Controllers\DatatableController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/components', function () {
    return view('component-test');
});

Route::get('/students', StudentController::class)->name('students');
Route::get('/users', UserController::class)->name('users');
Route::get('/datatable', DatatableController::class)->name('datatable');

require __DIR__.'/auth.php';
