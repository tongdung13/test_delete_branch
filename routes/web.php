<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('',[RegisteredUserController::class, 'create']);
Route::post('register',[RegisteredUserController::class, 'store'])->name('register');
Route::get('authenticate',[ChatController::class, 'login'])->name('auth');
Route::post('login',[AuthenticatedSessionController::class, 'store'])->name('login');

Route::prefix('home')->group(function () {
    Route::get('', [CategoryController::class, 'indexCms'])->name('categories.index');
    Route::get('export', [CategoryController::class, 'export'])->name('categories.export');
    Route::get('pdf', [CategoryController::class, 'pdf'])->name('categories.pdf');
    Route::get('send-mail', [CategoryController::class, 'sendMail'])->name('categories.sendMail');
});
Route::post('send-message', [ChatController::class, 'sendMessage'])->name('sendMessage');

Route::get('/dashboard', function () {
    return view('bot-man');
});
Route::match(['get', 'post'], '/botman-chat', 'BotManChatController@invoke');
