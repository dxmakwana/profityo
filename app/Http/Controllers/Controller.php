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
                    $table->string('user_id')->nullable();
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

              // Sales & payments....product module..
            if (!Schema::hasTable($storeId . '_py_sale_product')) {
                Schema::create($storeId . '_py_sale_product', function (Blueprint $table) {
                    $table->increments('sale_product_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_product_name')->nullable();
                    $table->string('sale_product_price')->nullable();
                    $table->string('sale_product_tax')->nullable();
                    $table->string('sale_product_sell')->nullable();
                    $table->string('sale_product_buy')->nullable();
                    $table->integer('sale_product_income_account')->nullable();
                    $table->integer('sale_product_expense_account')->nullable();
                    $table->string('sale_product_desc')->nullable();
                    $table->integer('sale_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_estimates_details')) {
                Schema::create($storeId . '_py_estimates_details', function (Blueprint $table) {
                    $table->increments('sale_estim_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_estim_title')->nullable();
                    $table->text('sale_estim_summary')->nullable();
                    $table->integer('sale_cus_id')->nullable();
                    $table->string('sale_estim_number')->nullable();
                    $table->string('sale_estim_customer_ref')->nullable();
                    $table->string('sale_estim_date')->nullable();
                    $table->string('sale_estim_valid_date')->nullable();
                    $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->text('sale_estim_discount_desc')->nullable();
                    $table->integer('sale_estim_discount_type')->nullable()->default(0);
                    $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->string('sale_estim_sub_total')->nullable()->default(0);
                    $table->string('sale_estim_discount_total')->nullable()->default(0);
                    $table->string('sale_estim_tax_amount')->nullable()->default(0);
                    $table->string('sale_estim_final_amount')->nullable()->default(0);
                    $table->string('sale_estim_notes')->nullable();
                    $table->string('sale_estim_footer_note')->nullable();
                    $table->string('sale_estim_image')->nullable();
                    $table->integer('sale_status')->nullable()->default(0);
                    $table->tinyInteger('sale_estim_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_estimates_items')) {
                Schema::create($storeId . '_py_estimates_items', function (Blueprint $table) {
                    $table->increments('sale_estim_item_id')->unique();
                    $table->integer('id')->nullable()->default(0);
                    $table->integer('sale_estim_id')->nullable()->default(0);
                    $table->integer('sale_product_id')->nullable()->default(0);
                    $table->integer('sale_estim_item_qty')->nullable()->default(0);
                    $table->string('sale_estim_item_price')->nullable()->default(0);
                    // $table->string('sale_estim_item_discount')->nullable()->default(0);
                    $table->string('sale_estim_item_tax')->nullable()->default(0);
                    $table->text('sale_estim_item_desc')->nullable();
                    $table->string('sale_estim_item_amount')->nullable()->default(0);
                    // $table->integer('sale_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_estim_item_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // Sales & payments....product module..
            if (!Schema::hasTable($storeId . '_py_sale_product')) {
                Schema::create($storeId . '_py_sale_product', function (Blueprint $table) {
                    $table->increments('sale_product_id');
                    $table->integer('id')->nullable()->default(0);
                    $table->string('sale_product_name')->nullable();
                    $table->string('sale_product_price')->nullable();
                    $table->string('sale_product_tax')->nullable();
                    $table->string('sale_product_sell')->nullable();
                    $table->string('sale_product_buy')->nullable();
                    $table->integer('sale_product_income_account')->nullable();
                    $table->integer('sale_product_expense_account')->nullable();
                    $table->string('sale_product_desc')->nullable();
                    $table->integer('sale_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // Sales & payments....chart _of_account..
            if (!Schema::hasTable($storeId . '_py_chart_account')) {
                Schema::create($storeId . '_py_chart_account', function (Blueprint $table) {
                    $table->increments('chart_acc_id');
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->integer('type_id')->nullable()->default(0);
                    $table->integer('acc_type_id')->nullable()->default(0);
                    $table->string('chart_acc_name')->nullable();
                    $table->integer('currency_id')->nullable()->default(0);
                    $table->integer('chart_account_id')->nullable()->default(0);
                    $table->string('sale_acc_desc')->nullable();
                    $table->tinyInteger('sale_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            // Purchases....product module..
            if (!Schema::hasTable($storeId . '_py_purchases_product')) {
                Schema::create($storeId . '_py_purchases_product', function (Blueprint $table) {
                    $table->increments('purchases_product_id');
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->string('purchases_product_name')->nullable();
                    $table->string('purchases_product_price')->nullable();
                    $table->string('purchases_product_tax')->nullable();
                    $table->string('purchases_product_sell')->nullable();
                    $table->string('purchases_product_buy')->nullable();
                    $table->integer('purchases_product_income_account')->nullable();
                    $table->integer('purchases_product_expense_account')->nullable();
                    $table->string('purchases_product_desc')->nullable();
                    $table->integer('purchases_product_currency_id')->nullable()->default(0);
                    $table->tinyInteger('purchases_product_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_purchases_vendor')) {
                Schema::create($storeId . '_py_purchases_vendor', function (Blueprint $table) {
                    $table->increments('purchases_vendor_id');
                    $table->integer('id')->nullable()->default(0);
                    // $table->integer('users_id')->nullable()->default(0);
                    $table->string('purchases_vendor_name')->nullable();
                    $table->string('purchases_vendor_type')->nullable();
                    $table->string('purchases_vendor_contractor_type')->nullable();
                    $table->string('purchases_contractor_type')->nullable();
                    $table->string('purchases_vendor_security_number')->nullable();
                    $table->string('purchases_vendor_first_name')->nullable();
                    $table->string('purchases_vendor_last_name')->nullable();
                    $table->string('purchases_vendor_email')->nullable();
                    $table->string('purchases_vendor_country_id')->nullable()->default(0);
                    $table->string('purchases_vendor_state_id')->nullable()->default(0);
                    $table->string('purchases_vendor_address1')->nullable();
                    $table->string('purchases_vendor_address2')->nullable();
                    $table->string('purchases_vendor_city_name')->nullable();
                    $table->string('purchases_vendor_zipcode')->nullable();
                    $table->string('purchases_vendor_account_number')->nullable();
                    $table->string('purchases_vendor_phone')->nullable();
                    $table->string('purchases_vendor_fax')->nullable();
                    $table->string('purchases_vendor_mobile')->nullable();
                    $table->string('purchases_vendor_toll_free')->nullable();
                    $table->string('purchases_vendor_website')->nullable();
                    $table->integer('purchases_vendor_currency_id')->nullable()->default(0);
                    $table->tinyInteger('purchases_vendor_status')->default(0)->nullable();
                    $table->timestamps();
                });
            }

            if (!Schema::hasTable($storeId . '_py_customize_menu_estimates')) {
                Schema::create($storeId . '_py_customize_menu_estimates', function (Blueprint $table) {
                    $table->increments('esti_cust_menu_id')->unique();
                    $table->integer('sale_estim_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->string('mname')->nullable();
                    $table->string('mtitle')->nullable();
                    $table->integer('mid')->nullable();
                    $table->integer('is_access')->nullable();
                    $table->string('esti_cust_menu_title')->nullable();
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
    
