<?php

use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

$adminRoute = config('global.superAdminURL');
$busadminRoute = config('global.businessAdminURL');

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'prefix' => $adminRoute], function() {

    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'prefix' => $busadminRoute], function() {
    Route::get('/login', function () {
        return view('welcome');
    });
});

require __DIR__.'/auth.php';
