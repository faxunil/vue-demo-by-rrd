<?php

use App\Http\Controllers\Api\ApiUserController;
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

Route::get('users', [ApiUserController::class,'index'])->name('users');

Route::post('login',[ApiUserController::class,'login'])->name('api.login');
Route::post('register',[ApiUserController::class,'register'])->name('api.register');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
