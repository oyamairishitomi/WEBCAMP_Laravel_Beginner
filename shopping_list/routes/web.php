<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\CompletedShoppingListController;
use App\Http\Controllers\Admin\AdminAuthController;

/*
|----------------------------------------------用----------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('front.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [UserController::class, 'index'])->name('register.index');
Route::post('/register', [UserController::class, 'register'])->name('register.register');

Route::middleware(['auth'])->group(function(){
  Route::get('/list', [ShoppingListController::class, 'list'])->name('list.list');
  Route::post('/list/register', [ShoppingListController::class, 'register'])->name('list.register');
  Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
  Route::post('/complete/{id}', [ShoppingListController::class, 'complete'])->name('complete');
  Route::get('/completed/list', [CompletedShoppingListController::class, 'list'])->name('complete.list');
  Route::delete('/delete/{id}', [ShoppingListController::class, 'delete'])->name('delete');
});

Route::prefix('/admin')->group(function() {
  Route::get('/login', [AdminAuthController::class, 'index']);
  Route::post('/login', [AdminAuthController::class, 'login']);
  Route::middleware(['auth:admin'])->group(function(){
    Route::get('/top', [AdminAuthController::class, 'top']);
    Route::get('/list', [AdminAuthController::class, 'list']);
    Route::get('/logout', [AdminAuthController::class, 'logout']);
  });
});