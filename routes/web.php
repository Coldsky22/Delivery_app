<?php

use Illuminate\Support\Facades\Route;
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

Auth::routes();


Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin', function () {return view('layouts/admin');
    });
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

