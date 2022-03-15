<?php

use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\TaskController;
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

Route::get('users', [ApiUserController::class,'index'])->name('api.users');

Route::post('login',[ApiUserController::class,'login'])->name('api.login');
Route::post('register',[ApiUserController::class,'register'])->name('api.register');


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::patch('/task/{task}/status', [TaskController::class,'changeStatus'])->name('api.tasks.status');
    Route::post('/task/{task}/restore', [TaskController::class,'restore'])->name('api.tasks.restore');

    //Route::get('/tasks', [TaskController::class,'index']);

    Route::resource('/task', TaskController::class);


//    Route::get('/task/1', [TaskController::class,'show'])->name('api.task.show');
//
//    Route::put('/task/1', [TaskController::class,'update'])->name('api.task.update');

});



