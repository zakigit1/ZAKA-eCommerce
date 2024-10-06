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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('product_id',false,true);
            $table->bigInteger('user_id',false,true);
            $table->bigInteger('vendor_id',false,true);

            $table->string('review')->nullable();
            $table->string('rating');
            $table->boolean('status');
            $table->timestamps();



            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');



            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            


                
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
