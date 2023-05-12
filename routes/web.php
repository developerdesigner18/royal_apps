<?php

use App\Http\Controllers\authorsController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\clientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/client',[clientController::class,'index'])->name('client-login');
Route::get('/client/create',[clientController::class,'create_index'])->name('client-create');
Route::get('/authors',[authorsController::class,'index'])->name('authors');
Route::get('/add-book',[bookController::class,'index'])->name('add-book');
Route::get('/authors/{authors}',[authorsController::class,'authors_books'])->name('authors_books');
Route::post('/store-token',[clientController::class,'store_token'])->name('store-token');
Route::post('/create-client',[clientController::class,'create'])->name('create-client');
