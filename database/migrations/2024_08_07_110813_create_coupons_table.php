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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('name');
            $table->string('code')->unique();//this need to be unique (i update 04/12/2024)
            $table->integer('quantity');
            $table->integer('max_use');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('discount_type');
            $table->double('discount');
            $table->boolean('status');
            $table->integer('total_used');
            // $table->float('min_purchase_amount', 10, 2)->unsigned()->default(0.00);
            $table->timestamps();

            $table->foreign('vendor_id')
            ->references('id')
            ->on('vendors')
            ->onDelete('cascade')
            ->onUpdate('cascade'); // Added onUpdate cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
