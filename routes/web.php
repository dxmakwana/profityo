<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\PlanController;

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
global $adminRoute;
$adminRoute = config('global.superAdminURL');
$busadminRoute = config('global.businessAdminURL');

Route::group(['prefix' => $adminRoute], function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        //profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //Subscription Plans
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('/plans/store', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/edit/{plan}', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/update/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/destroy/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
        Route::get('/plans/planrole/{plan}', [PlanController::class, 'planrole'])->name('plans.planrole');
        Route::put('/plans/updaterole/{plan}', [PlanController::class, 'updaterole'])->name('plans.updaterole');

        //  Route::resources([
        //     'plans' => PlanController::class,
        // ]);

        // Route::get('/plans/planrole', [PlanController::class, 'planrole'])->name('plans.planrole');
        // Route::get('admin/plans/role', [App\Http\Controllers\superadmin\PlanController::class, 'role'])->name('admin.plans.role');



        
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'prefix' => $busadminRoute], function() {
    Route::get('/login', function () {
        return view('welcome');
    });
});

require __DIR__.'/auth.php';
