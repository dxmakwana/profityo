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
        Schema::create('py_chart_account_menu', function (Blueprint $table) {
            $table->integer('chart_menu_id')->unique()->primary();
            $table->integer('menu_id')->nullable()->default('0');
            $table->string('chart_menu_title')->nullable();
            $table->tinyInteger('chart_menu_status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('py_chart_account_menu');
    }
};
