<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\MasterUser;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function handleImageUpload(Request $request, $currentImage = null, $directory = 'default_directory')
    {
        
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($currentImage) {
                Storage::delete($directory . '/' . $currentImage);
            }

            // Generate a unique filename
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFilename = Str::uuid() . '.' . $extension;

            // Store the new image
            $request->file('image')->storeAs($directory, $uniqueFilename);
            
            return $uniqueFilename;
        }

        return $currentImage;
    }

    public function CreateTable($id){
        $master_user = MasterUser::find($id);
        if($master_user){
            $storeId = $master_user->buss_unique_id;
            if (!Schema::hasTable($storeId.'_py_log_activities_table')){   
                Schema::create($storeId.'_py_log_activities_table', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('subject')->nullable();
                    $table->string('url')->nullable();
                    $table->string('method')->nullable();
                    $table->string('ip')->nullable();
                    $table->string('agent')->nullable();
                    $table->integer('user_id')->nullable()->default(0);
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId.'_py_users_role')){  
                Schema::create($storeId.'_py_users_role', function (Blueprint $table) {
                    $table->increments('role_id');
                    $table->integer('id');
                    $table->string('role_name');
                    $table->tinyInteger('role_status')->default(0);
                    $table->timestamps();
                });

            }else{
                Schema::table($storeId.'_py_users_role', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_users_role', 'id')) {
                        $table->integer('id');
                    }
                });
            }

            if (!Schema::hasTable($storeId.'_py_users_details')){   
                Schema::create($storeId.'_py_users_details', function (Blueprint $table) {
                    $table->increments('users_id');
                    $table->string('users_name')->nullable();
                    $table->string('users_email')->nullable()->unique();
                    $table->string('email_verified_at')->nullable()->unique();
                    $table->string('users_phone')->nullable()->unique();
                    $table->string('users_password')->nullable();
                    $table->integer('role_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('user_id')->nullable();
                    $table->string('remember_token')->nullable();
                    $table->tinyInteger('users_status')->default(0)->nullable();
                    $table->string('users_image')->nullable();
                    $table->integer('country_id')->nullable()->default(0);
                    $table->integer('state_id')->nullable()->default(0);
                    $table->string('users_city_name')->nullable();
                    $table->string('users_pincode')->nullable();
                    $table->timestamps();
                });
            }else{
                
                Schema::table($storeId.'_py_users_details', function (Blueprint $table) use ($storeId) {
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_image')) {
                        $table->string('users_image')->nullable();
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'country_id')) {
                        $table->integer('country_id');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'state_id')) {
                        $table->integer('state_id');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_city_name')) {
                        $table->string('users_city_name');
                    }
                
                    if (!Schema::hasColumn($storeId.'_py_users_details', 'users_pincode')) {
                        $table->string('users_pincode');
                    }
                });
            }

            if (!Schema::hasTable($storeId.'_py_business_details')){   
                Schema::create($storeId.'_py_business_details', function (Blueprint $table) {
                    $table->increments('bus_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('bus_company_name')->nullable();
                    $table->string('bus_image')->nullable();
                    $table->integer('state_id')->nullable()->default(0);
                    $table->integer('country_id')->nullable()->default(0);
                    $table->string('city_name')->nullable();
                    $table->string('zipcode')->nullable();
                    $table->string('bus_address1')->nullable();
                    $table->string('bus_address2')->nullable();
                    $table->string('bus_phone')->nullable();
                    $table->string('bus_mobile')->nullable();
                    $table->string('bus_website')->nullable();
                    $table->integer('bus_currency')->nullable()->default(0);
                    $table->tinyInteger('bus_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId.'_py_sales_tax')){   
                Schema::create($storeId.'_py_sales_tax', function (Blueprint $table) {
                    $table->increments('tax_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('tax_name')->nullable();
                    $table->string('tax_abbreviation')->nullable();
                    $table->integer('tax_number')->nullable();
                    $table->string('tax_desc')->nullable();
                    $table->string('tax_number_invoices')->nullable();
                    $table->string('tax_recoverable')->nullable();
                    $table->string('tax_compound')->nullable();
                    $table->integer('tax_rate')->nullable()->default(0);
                    $table->tinyInteger('tax_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // master user access
            if (!Schema::hasTable($storeId.'_py_master_user_access')){   
                Schema::create($storeId.'_py_master_user_access', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('u_id')->nullable()->default(0);
                    $table->integer('role_id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->string('is_access')->nullable();
                    $table->timestamps();
                });
            }
            // end by dx....

            // SalesCustomer...
            if (!Schema::hasTable($storeId . '_py_sale_customers')) {
                Schema::create($storeId . '_py_sale_customers', function (Blueprint $table) {
                    $table->increments('sale_cus_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('users_id')->nullable()->default(0);
                    $table->string('sale_cus_business_name')->nullable();
                    $table->string('sale_cus_first_name')->nullable();
                    $table->string('sale_cus_last_name')->nullable();
                    $table->string('sale_cus_email')->nullable();
                    $table->string('sale_cus_phone')->nullable();
                    $table->string('sale_cus_fax')->nullable();
                    $table->string('sale_cus_mobile')->nullable();
                    $table->string('sale_cus_toll_free')->nullable();
                    $table->string('sale_cus_account_number')->nullable();
                    $table->string('sale_cus_website')->nullable();
                    $table->string('sale_cus_notes')->nullable();
                    $table->integer('sale_bill_currency_id')->nullable()->default(0);
                    $table->string('sale_bill_address1')->nullable();
                    $table->string('sale_bill_address2')->nullable();
                    $table->integer('sale_bill_country_id')->nullable()->default(0);
                    $table->string('sale_bill_city_name')->nullable();
                    $table->string('sale_bill_zipcode')->nullable();
                    $table->integer('sale_bill_state_id')->nullable()->default(0);
                    $table->string('sale_ship_shipto')->nullable();
                    $table->integer('sale_ship_currency_id')->nullable()->default(0);
                    $table->string('sale_ship_address1')->nullable();
                    $table->string('sale_ship_address2')->nullable();
                    $table->integer('sale_ship_country_id')->nullable()->default(0);
                    $table->string('sale_ship_city_name')->nullable();
                    $table->string('sale_ship_zipcode')->nullable();
                    $table->integer('sale_ship_state_id')->nullable()->default(0);
                    $table->string('sale_ship_phone')->nullable();
                    $table->string('sale_ship_delivery_desc')->nullable();
                    $table->string('sale_same_address')->nullable();
                    $table->tinyInteger('sale_cus_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

        }
    }

    public function createTableRoute(Request $request)
    {
        
       $user = Auth::guard('masteradmins')->user();
        //dd($user);
        $id = $user->id;

        if (!$id) {
            return response()->json(['message' => 'ID is required'], 400);
        }
        try {
            $this->CreateTable($id);
            return response()->json(['message' => 'Table created or modified successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

}
    
