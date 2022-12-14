<?php

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::post('/thread_store', [App\Http\Controllers\HomeController::class, 'thread_store'])->name('thread_store')->middleware('auth');
Route::get('/thread/{thread}', [App\Http\Controllers\HomeController::class, 'thread'])->name('thread');
Route::post('/reply_store', [App\Http\Controllers\HomeController::class, 'reply_store'])->name('reply_store')->middleware('auth');
Route::post('/thread_delete', [App\Http\Controllers\DeleteController::class, 'thread_delete'])->name('thread_delete');
Route::post('/reply_delete', [App\Http\Controllers\DeleteController::class, 'reply_delete'])->name('reply_delete');
// ブックマークボタン
Route::get('/mark/{thread}', [App\Http\Controllers\MarkController::class, 'mark'])->name('mark');
Route::get('/unmark/{thread}', [App\Http\Controllers\MarkController::class, 'unmark'])->name('unmark');