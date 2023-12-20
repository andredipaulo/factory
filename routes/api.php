<?php

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
Route::get('sponsors', [\App\Http\Controllers\SponsorController::class, 'list']);
Route::get('sponsors/{id}', [\App\Http\Controllers\SponsorController::class, 'sponsor']);
Route::post('sponsors', [\App\Http\Controllers\SponsorController::class, 'new']);
Route::put('sponsors/{id}', [\App\Http\Controllers\SponsorController::class, 'up']);
Route::delete('sponsors/{id}', [\App\Http\Controllers\SponsorController::class, 'del']);

Route::get('clients', [\App\Http\Controllers\ClientController::class, 'list']);
Route::get('clients/{id}', [\App\Http\Controllers\ClientController::class, 'client']);
Route::post('clients', [\App\Http\Controllers\ClientController::class, 'new']);
Route::put('clients/{id}', [\App\Http\Controllers\ClientController::class, 'up']);
Route::delete('clients/{id}', [\App\Http\Controllers\ClientController::class, 'del']);

Route::get('loans', [\App\Http\Controllers\LoanController::class, 'list']);
Route::get('loans/{id}', [\App\Http\Controllers\LoanController::class, 'loan']);
Route::post('loans', [\App\Http\Controllers\LoanController::class, 'new']);
Route::put('loans/{id}', [\App\Http\Controllers\LoanController::class, 'up']);
Route::delete('loans/{id}', [\App\Http\Controllers\LoanController::class, 'del']);

Route::get('payments', [\App\Http\Controllers\PaymentController::class, 'list']);
Route::post('payments', [\App\Http\Controllers\PaymentController::class, 'new']);
Route::delete('payments/{id}', [\App\Http\Controllers\PaymentController::class, 'del']);

Route::get('users', [\App\Http\Controllers\UserController::class, 'list']);
Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'user']);
Route::post('users', [\App\Http\Controllers\UserController::class, 'new']);
Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'up']);
Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'del']);

Route::get('simulator', function (Request $request) {

});
