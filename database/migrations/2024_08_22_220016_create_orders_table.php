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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->bigInteger('user_id',false,true);
            $table->double('sub_total');
            $table->double('amount');
            $table->string('currency_name');
            $table->string('currency_icon');
            $table->integer('product_qty');
            $table->string('payment_method');
            $table->boolean('payment_status');

            // this three fields(order_address,shipping_method,coupon) we want to enter a json data 
            $table->text('order_address');
            $table->text('shipping_method');
            $table->text('coupon');

            $table->string('order_status');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
