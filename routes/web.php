<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('sponsors', \App\Http\Controllers\SponsorController::class);
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    Route::resource('loans', \App\Http\Controllers\LoanController::class);
    Route::resource('payments', \App\Http\Controllers\PaymentController::class);

    Route::get('/generator', function () {
        return view('generator.index');
    })->name('generator');

    Route::get('/getClientData/{id}', [\App\Http\Controllers\ClientController::class, 'getClientData']);
    Route::get('/getLoan/{id}', [\App\Http\Controllers\LoanController::class, 'getLoan']);
});

Route::get('/simulator', function (){
    return view('simulator.index');
})->name('simulator');
Route::post('/gerar-pdf/{tabela}', [\App\Http\Controllers\PdfController::class, 'gerarPDF']);
