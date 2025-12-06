<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\NeedlistController;
use App\Http\Controllers\CargolistController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    if (Auth::check()) {
        return redirect('/iz/needlist');
    }
    return Inertia::render('Welcome');
})
    ->name('home');

Route::group(['middleware' => Authenticate::NAME, 'prefix' => 'iz'], function () {
    Route::get('/needlist', [NeedlistController::class, 'index'])
        ->name('needlist');

    Route::get('/needlist/{inquiry}', [NeedlistController::class, 'show'])
        ->name('needlist.show');

    Route::put('/needlist/{inquiry}', [NeedlistController::class, 'update'])
        ->name('needlist.update');

    Route::get('/cargolist', [CargolistController::class, 'index']);

    Route::post('/cargolist',[CargolistController::class, 'create']);
});

Route::get('/inquiry', [InquiryController::class, 'create'])
    ->name('inquiry.create');


Route::post('/inquiry', [InquiryController::class, 'store'])
    ->name('inquiry.store');

Route::get('/inquiry/sizes/{product}', [InquiryController::class, 'getSize'])
    ->name('inquiry.sizes');

Route::get('/inquiry/success', fn () => Inertia::render('Success'))
    ->name('inquiry.success');

require __DIR__ . '/auth.php';
