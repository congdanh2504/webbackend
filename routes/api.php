<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PostController;
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

Route::get('/user/{id}', [AuthController::class, 'userById']);

// Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/login/google', [AuthController::class, 'loginWithGG']);

Route::post('/register/google/{type}', [AuthController::class, 'registerWithGG']);

Route::get('/postItem', [PostController::class, 'getAllPosts']);

Route::get('/postItem/{id}', [PostController::class, 'getPostByID']);

// test post 
Route::put('/postItem/{id}', [PostController::class, 'update']);

Route::delete('/postItem/{id}', [PostController::class, 'delete']);

Route::get('/blog', [BlogController::class, 'getAllBlogs']);

Route::get('/blog/{id}', [BlogController::class, 'getById']);

Route::get('/blog/new/{limit}', [BlogController::class, 'getNewBlogs']);

Route::get('/employer', [EmployerController::class, 'employers']);

Route::post('/postItem/search', [PostController::class, 'search']);

Route::get('/postItem/myPost/{id}', [PostController::class, 'getMyPosts']);

Route::middleware('auth.jwt')->group(function () {
    Route::post('/review', [EmployeeController::class, 'addReview']);

    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/blog', [BlogController::class, 'addBlog']);

    Route::delete('/postItem/{id}', [AdminController::class, 'deletePostItem']);

    Route::post('/postItem', [PostController::class, 'postJob']);  

    Route::post('/employeeUpdateProfile', [EmployeeController::class, 'employeeUpdateProfile']);

    Route::post('/employerUpdateProfile', [EmployerController::class, 'employerUpdateProfile']);

    Route::patch('/postItem', [PostController::class, 'updateJob']);  

    Route::post('/apply',  [PostController::class, 'addApply']);

    Route::middleware('admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/employees', [AdminController::class, 'employees']);
            Route::get('/employers', [AdminController::class, 'employers']);
            Route::delete('users/{id}', [AdminController::class, 'deleteUser']);
            Route::delete('/blog/{id}', [AdminController::class, 'deleteBlog']);
            Route::delete('/postItem/{id}', [AdminController::class, 'deletePostItem']);
            Route::get('/report', [AdminController::class, 'report']);
        });
    });

});
