<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('py_customize_menu', function (Blueprint $table) {
            $table->integer('cust_menu_id')->unique()->primary();
            $table->string('mname')->nullable();
            $table->string('mtitle')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('pmenu')->nullable();
            $table->tinyInteger('cust_menu_status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('py_customize_menu');
    }
};
