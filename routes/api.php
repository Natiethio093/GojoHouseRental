<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getUserData', [UserController::class, 'getUserData']);
});

Route::post('/Register',[UserController::class,"Register"]);
Route::post('/Login',[UserController::class,'Login']);
Route::get('auth/google', [UserController::class, 'googlepage']);
Route::get('auth/google/callback', [UserController::class, 'googlecallbacklogin']);


