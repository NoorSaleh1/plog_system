<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LogInController;



Route::post('login', [LogInController::class,'login']);
Route::post('register', [LogInController::class,'register']);
Route::delete('logout', [LogInController::class,'logout'])->middleware('auth:sanctum');

Route::resource('users',LogInController::class)->except(['create','edit'])->middleware(['auth:sanctum','role:admin']);
Route::resource('Post',PostController::class)->except(['create','edit'])->middleware('auth:sanctum','role:admin');
Route::resource('post',PostController::class)->only(['index','show'])->middleware('auth:sanctum','role:user,admin');
Route::resource('comment',CommentController::class)->except(['create','edit'])->middleware('auth:sanctum');



