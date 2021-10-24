<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
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

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/getUserById/{id}', [AuthController::class, 'userById']);

// Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/loginWithGG',[AuthController::class, 'loginWithGG']);

Route::post('/registerWithGG/{type}',[AuthController::class, 'registerWithGG']);

Route::get('/postItem', [PostController::class, 'getAllPosts']);
Route::get('/postItem/{id}', [PostController::class, 'getPost']);
// test post 
Route::put('/postUpdate/{id}', [postController::class, 'update']);
Route::delete('/postDelete/{id}', [PostController::class, 'delete']); 

Route::get('/blog', [BlogController::class, 'getAllBlogs']);

Route::get('/blog/{id}', [BlogController::class, 'getById']);

Route::get('/new-blogs', [BlogController::class, 'getNewBlogs']);

Route::get('/employer', [EmployeeController::class, 'getAllEmployers']);

Route::middleware('auth.jwt')->group(function () {
    Route::get('/user',[AuthController::class, 'user']);

    Route::post('/addBlog', [BlogController::class, 'addBlog']);

    Route::post('/postJob', [PostController::class, 'postJob']);
    Route::post('/employeeUpdateProfile', [EmployeeController::class, 'employeeUpdateProfile']);
});

