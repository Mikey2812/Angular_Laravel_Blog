<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Middleware\VerifyUser;

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

Route::post('login', [UsersController::class, 'login']);
Route::get('/topics', [TopicsController::class, 'getAlls']);
Route::get('/posts', [PostsController::class, 'getAlls']);
Route::post('/posts/add', [PostsController::class, 'addPost'])->middleware('verifyuser');
Route::get('/posts/{id}', [PostsController::class, 'getByID']);