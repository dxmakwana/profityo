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
                    $table->string('users_phone')->nullable()->unique();
                    $table->string('users_password')->nullable();
                    $table->integer('role_id')->nullable()->default(0);
                    $table->integer('id')->nullable()->default(0);
                    $table->tinyInteger('users_status')->default(0)->nullable();
                    $table->timestamps();
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

            // add by dx.......
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
            // end by dx....

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
    
