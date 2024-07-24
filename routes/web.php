<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superadmin\PlanController;
use App\Http\Controllers\Auth\MasterAdmin\RegisterController;
use App\Http\Controllers\Auth\MasterAdmin\LoginController;
use App\Http\Controllers\Auth\MasterAdmin\MasterPasswordResetLinkController;
use App\Http\Controllers\Auth\MasterAdmin\MasterNewPasswordController;
use App\Http\Controllers\Auth\MasterAdmin\MasterEmailVerificationPromptController;
use App\Http\Controllers\Auth\MasterAdmin\MasterEmailVerificationNotificationController;
use App\Http\Controllers\Masteradmin\HomeController;
use App\Http\Controllers\Masteradmin\ProfilesController;
use App\Http\Controllers\Auth\MasterAdmin\MasterPasswordController;
use App\Http\Controllers\Controller;




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
  
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('auth.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
    
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
        
        //logs
        Route::get('/logActivity', [ProfileController::class, 'logActivity'])->name('adminlog.index');
        
    });
});

Route::group(['prefix' => $busadminRoute], function () {
    
    Route::middleware('masteradmin')->group(function () {
        //login and register
        Route::get('login', [LoginController::class, 'create'])->name('business.login');
        Route::get('register', [RegisterController::class, 'create'])->name('business.register');
        Route::post('register', [RegisterController::class, 'store'])->name('business.register.store');
        Route::post('login', [LoginController::class, 'store'])->name('business.login.store');
        Route::get('forgot-password', [MasterPasswordResetLinkController::class, 'create'])
                        ->name('business.password.request');
        Route::post('forgot-password', [MasterPasswordResetLinkController::class, 'store'])
                        ->name('business.password.email');
        Route::get('reset-password/{token}', [MasterNewPasswordController::class, 'create'])
                        ->name('business.password.reset');
        Route::post('reset-password', [MasterNewPasswordController::class, 'store'])
                        ->name('business.password.store');
                
    });
    Route::middleware(['auth_master'])->group(function () {
        
        //profile
        Route::get('/dashboard', [HomeController::class, 'create'])->name('business.home');
        Route::get('/profile', [ProfilesController::class, 'edit'])->name('business.profile.edit');
        Route::patch('/profile', [ProfilesController::class, 'update'])->name('business.profile.update');
        Route::delete('/profile', [ProfilesController::class, 'destroy'])->name('business.profile.destroy');
        Route::get('states/{countryId}', [ProfilesController::class, 'getStates']);
        Route::put('password', [MasterPasswordController::class, 'update'])->name('business.password.update');
        Route::post('logout', [LoginController::class, 'destroy'])->name('business.logout');
        //create alter database
        Route::get('/create-table', [Controller::class, 'createTableRoute']);

        //Business Profile
        Route::get('/business-profile', [ProfilesController::class, 'businessProfile'])->name('business.business.edit');
        Route::patch('/business-profile-update', [ProfilesController::class, 'businessProfileUpdate'])->name('business.business.update');

        // //exp plan or not plan purchase
        // Route::get('/plan/purchase', [ProfilesController::class, 'purchase'])->name('business.plan.purchase');
        
    });
    
});

require __DIR__.'/auth.php';
