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
        Schema::create('py_payment_methods', function (Blueprint $table) {
            $table->integer('m_id')->unique()->primary();
            $table->string('method_name')->nullable();
            $table->tinyInteger('method_status')->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('py_payment_methods');
    }
};
