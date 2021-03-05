<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/verify', function () {
    return view('auth.verify');
})->middleware('guest')->name('verify');

Route::post('/verifydna', [AuthenticatedSessionController::class, 'verifyTypingDNA'])->middleware('guest')->name('verifydna');



require __DIR__.'/auth.php';
