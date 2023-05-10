<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TopicsController;
use App\Http\Middleware\VerifyUser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

//Post
Route::prefix('/posts')->group(function () {
    Route::get('', [PostsController::class, 'getAlls']);
    Route::get('/user/{id}', [PostsController::class, 'getByUserID']);
    Route::get('/{id}', [PostsController::class, 'getByID']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/add', [PostsController::class, 'addPost']);
        Route::post('/{id}', [PostsController::class, 'editPost']);
        Route::delete('/{id}', [PostsController::class, 'delPost']);
    });
});

//Comment
Route::prefix('/comments')->group(function () {
    Route::get('/posts/{id}', [CommentsController::class, 'getByPostID']);
    // Route::get('/posts/{id}', [CommentsController::class, 'getByPostID']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/add', [CommentsController::class, 'addComments']);
    });
    
});

//Like
Route::prefix('/likes')->group(function () {
    Route::get('/users/{user_id}/{type}', [LikesController::class, 'getByUserID']);
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('', [LikesController::class, 'addLike']);
        Route::delete('/{location_id}/{type}', [LikesController::class, 'delByLocationID']);
    });
});

Route::get('/test');


Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/storage/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->where('filename', '.*');