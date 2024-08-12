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
use App\Http\Controllers\superadmin\HomesController;
use App\Http\Controllers\Masteradmin\UserRoleController;
use App\Http\Controllers\Masteradmin\SalesTaxController;
use App\Http\Controllers\Masteradmin\UserController;
use App\Http\Controllers\Masteradmin\SalesCustomersController;
use App\Http\Controllers\superadmin\BusinessDetailController;
use App\Http\Controllers\Masteradmin\EstimatesController;
use App\Http\Controllers\Masteradmin\SalesProductController;
use App\Http\Controllers\Masteradmin\PurchasProductController;


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
  
    Route::middleware(['auth'])->group(function () {
     
        Route::get('/dashboard', [HomesController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');
    
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
        
        Route::get('/businessdetails', [BusinessDetailController::class, 'index'])->name('businessdetails.index');
        Route::get('/businessdetails/{id}', [BusinessDetailController::class, 'show'])->name('businessdetails.show');

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

        //user change password
        Route::get('/users/change-password', [UserController::class, 'changePassword'])
                        ->name('business.userdetail.changePassword');
        Route::post('/users/store-password/{user_id}', [UserController::class, 'storePassword'])
                        ->name('business.userdetail.storePassword');
       
                
    });

    Route::middleware(['auth_master','set.user.details'])->group(function () {
        
        //profile
        Route::get('/dashboard', [HomeController::class, 'create'])->name('business.home');
        Route::get('/profile', [ProfilesController::class, 'edit'])->name('business.profile.edit');
        Route::patch('/profile', [ProfilesController::class, 'update'])->name('business.profile.update');
        Route::delete('/profile', [ProfilesController::class, 'destroy'])->name('business.profile.destroy');
        Route::get('states/{countryId}', [ProfilesController::class, 'getStates'])->name('business.profile.destroy');
        Route::put('password', [MasterPasswordController::class, 'update'])->name('states.get');
        Route::post('logout', [LoginController::class, 'destroy'])->name('business.logout');
        //create alter database
        Route::get('/create-table', [Controller::class, 'createTableRoute']);

        //Business Profile
        Route::get('/business-profile', [ProfilesController::class, 'businessProfile'])->name('business.business.edit');
        Route::patch('/business-profile-update', [ProfilesController::class, 'businessProfileUpdate'])->name('business.business.update');
        Route::patch('/business-profile-edit', [ProfilesController::class, 'updateBusinessDetails'])->name('business.business.edits');

        //Log Activity
        Route::get('/logActivity', [ProfilesController::class, 'logActivity'])->name('business.masterlog.index');
        
        // //exp plan or not plan purchase
        // Route::get('/plan/purchase', [ProfilesController::class, 'purchase'])->name('business.plan.purchase');
        
        //User Role
        Route::get('user-role-details', [UserRoleController::class, 'index'])->name('business.role.index');
        Route::get('rolecreate', [UserRoleController::class, 'create'])->name('business.role.create');
        Route::post('roleadd', [UserRoleController::class, 'store'])->name('business.role.store');
        Route::get('roleedit/{role}', [UserRoleController::class, 'edit'])->name('business.role.edit');
        Route::patch('roleupdate/{role}', [UserRoleController::class, 'update'])->name('business.role.update');
        Route::delete('roledestroy/{role}', [UserRoleController::class, 'destroy'])->name('business.role.destroy');
        Route::get('userrole/{userrole}', [UserRoleController::class, 'userrole'])->name('business.role.userrole');
        Route::put('updaterole/{userrole}', [UserRoleController::class, 'updaterole'])->name('business.role.updaterole');
                        
        //saletax
        Route::get('/salestax', [SalesTaxController::class, 'index'])->name('business.salestax.index');
        Route::get('/taxcreate', [SalesTaxController::class, 'create'])->name('business.salestax.create');
        Route::post('/taxstore', [SalesTaxController::class, 'store'])->name('business.salestax.store');
        Route::get('/taxedit/{SalesTax}', [SalesTaxController::class, 'edit'])->name('business.salestax.edit');
        Route::patch('/taxupdate/{SalesTax}', [SalesTaxController::class, 'update'])->name('business.salestax.update');
        Route::delete('/taxdestroy/{salestax}', [SalesTaxController::class, 'destroy'])->name('business.salestax.destroy');

        // add by dx....master user details
        Route::get('/userdetails', [UserController::class, 'index'])->name('business.userdetail.index');
        Route::get('/usercreate', [UserController::class, 'create'])->name('business.userdetail.create');
        Route::post('/userstore', [UserController::class, 'store'])->name('business.userdetail.store');
        Route::get('/useredit/{userdetaile}', [UserController::class, 'edit'])->name('business.userdetail.edit');
        
        Route::patch('/userupdate/{userdetail}', [UserController::class, 'update'])->name('business.userdetail.update');
        Route::delete('/userdestroy/{userdetail}', [UserController::class, 'destroy'])->name('business.userdetail.destroy');
        
        //salesCustomer...
        Route::get('/salescustomers', [SalesCustomersController::class, 'index'])->name('business.salescustomers.index');
        Route::get('/customercreate', [SalesCustomersController::class, 'create'])->name('business.salescustomers.create');
        Route::post('/customerstore', [SalesCustomersController::class, 'store'])->name('business.salescustomers.store');
        Route::get('/customeredit/{SalesCustomers}', [SalesCustomersController::class, 'edit'])->name('business.salescustomers.edit');
        Route::patch('/customerupdate/{SalesCustomers}', [SalesCustomersController::class, 'update'])->name('business.salescustomers.update');
        Route::delete('/customerdestroy/{SalesCustomers}', [SalesCustomersController::class, 'destroy'])->name('business.salescustomers.destroy');
        Route::get('getstates/{country_id}', [SalesCustomersController::class, 'customerStates'])->name('get.states');
        Route::get('/get-customer-info', [SalesCustomersController::class, 'getCustomerInfo'])->name('business.salescustomers.getCustomerInfo');

        //estimates
        Route::get('/estimates-list', [EstimatesController::class, 'index'])->name('business.estimates.index');
        Route::get('/create-estimates', [EstimatesController::class, 'create'])->name('business.estimates.create');
        Route::get('/get-product-details/{id}', [EstimatesController::class, 'getProductDetails'])->name('business.estimates.getProductDetails');
        Route::post('/estimates-store', [EstimatesController::class, 'store'])->name('business.estimates.store');
        Route::get('/edit-estimates/{id}', [EstimatesController::class, 'edit'])->name('business.estimates.edit');
        Route::patch('/update-estimates/{estimates_id}', [EstimatesController::class, 'update'])->name('business.estimates.update');
        Route::delete('/estimatesdestroy/{id}', [EstimatesController::class, 'destroy'])->name('business.estimates.destroy');


        Route::put('salescustomers/{sale_cus_id}', [EstimatesController::class, 'updateCustomer'])->name('salescustomers.update');
        Route::get('salescustomers/list', [EstimatesController::class, 'listCustomers'])->name('salescustomers.list');

    

        //sales product
        Route::get('/salesproduct', [SalesProductController::class, 'index'])->name('business.salesproduct.index');
        Route::get('/productcreate', [SalesProductController::class, 'create'])->name('business.salesproduct.create');
        Route::post('/salesproductstore', [SalesProductController::class, 'store'])->name('business.salesproduct.store');
        Route::get('/productedit/{SalesProduct}', [SalesProductController::class, 'edit'])->name('business.salesproduct.edit');
        Route::patch('/productupdate/{SalesProduct}', [SalesProductController::class, 'update'])->name('business.salesproduct.update');
        Route::delete('/productdestroy/{salesproduct}', [SalesProductController::class, 'destroy'])->name('business.salesproduct.destroy');
        Route::get('getstates/{country_id}', [SalesProductController::class, 'productStates'])->name('get.states');

        //  purchase product
        Route::get('/purchasesproduct', [PurchasProductController::class, 'index'])->name('business.purchasproduct.index');
        Route::get('/purchasesproductcreate', [PurchasProductController::class, 'create'])->name('business.purchasproduct.create');
        Route::post('/purchasesproductstore', [PurchasProductController::class, 'store'])->name('business.purchasproduct.store');
        Route::get('/purchasesproductedit/{PurchasesProduct}', [PurchasProductController::class, 'edit'])->name('business.purchasproduct.edit');
        Route::patch('/purchasesproductupdate/{PurchasesProduct}', [PurchasProductController::class, 'update'])->name('business.purchasproduct.update');
        Route::delete('/purchasesproductdestroy/{PurchasesProduct}', [PurchasProductController::class, 'destroy'])->name('business.purchasproduct.destroy');
      //   Route::get('getstates/{country_id}', [PurchasProductController::class, 'productStates'])->name('get.states');
    });
    
});

require __DIR__.'/auth.php';
