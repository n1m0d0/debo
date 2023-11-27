<?php

use App\Http\Controllers\PageController;
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
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(PageController::class)->group(function () {
    Route::get('user', 'user')->name('page.user')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin']);
    Route::get('company', 'company')->name('page.company')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin']);
    Route::get('category', 'category')->name('page.category')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin']);
    Route::get('product', 'product')->name('page.product')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin']);    
    Route::get('order', 'order')->name('page.order')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin']);
});