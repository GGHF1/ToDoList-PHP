<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoListController;
use App\Http\Controllers\UserController;

Route::get('/', [ToDoListController::class, 'index'])->middleware('auth');

Route::post('/saveItemRoute', [ToDoListController::class, 'saveItem'])->name('saveItem');
Route::post('/markComplRoute/{id}', [ToDoListController::class, 'markCompl'])->name('markCompl');
Route::post('/deleteItemRoute/{id}', [ToDoListController::class, 'deleteItem'])->name('deleteItem');

Route::get('/register', [UserController::class, 'showRegistrationForm']);
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'showLoginForm']);
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/change-password', [UserController::class, 'ChangePasswordForm']);
Route::post('/change-password', [UserController::class, 'changepassword'])->name('changepassword');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');