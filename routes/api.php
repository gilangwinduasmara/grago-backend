<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('auth/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('auth/profile', [\App\Http\Controllers\AuthController::class, 'profile']);


Route::resource('threads', \App\Http\Controllers\ThreadController::class);
Route::resource('threads.replies', \App\Http\Controllers\Thread\ReplyController::class);
Route::resource('threads.votes', \App\Http\Controllers\Thread\VoteController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::post('upload', [\App\Http\Controllers\FileableController::class, 'store']);
