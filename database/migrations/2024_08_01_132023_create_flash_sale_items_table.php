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
        Schema::create('flash_sale_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id',false,true)->nullable();
            $table->bigInteger('flash_sale_id',false,true)->nullable();
            $table->boolean('show_at_home');
            $table->boolean('status');
            $table->timestamps();
            
            
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('flash_sale_id')->references('id')->on('flash_sales')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_items');
    }
};
