<?php

use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('user', function () {
    return auth()->user();
});
Route::resource('users', UserController::class)->middleware(['auth:sanctum', 'verified']);
Route::resource('expenditures', ExpenditureController::class)->middleware(['auth:sanctum', 'verified']);
