<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

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

<<<<<<< HEAD
=======
// Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
>>>>>>> 0152b24cad519c3f30f8cf0343e1fd4076aa0668
Route::resource('departments', DepartmentController::class);
