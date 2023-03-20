<?php

use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('categories')->group(function () {
    Route::get('', [CategoryController::class, 'indexCms'])->name('categories.index');
    Route::get('export', [CategoryController::class, 'export'])->name('categories.export');
    Route::get('pdf', [CategoryController::class, 'pdf'])->name('categories.pdf');
    Route::get('send-mail', [CategoryController::class, 'sendMail'])->name('categories.sendMail');
});
Route::post('sendmessage', [ChatController::class, 'sendMessage'])->name('chat');
