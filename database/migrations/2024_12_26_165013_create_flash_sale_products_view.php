<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW flash_sale_products_view AS
        SELECT 
            p.id as product_id,
            p.name as product_name
        FROM products p 
        WHERE p.id NOT IN (SELECT product_id FROM flash_sale_items)
        AND p.status = 1
        AND p.is_approved = 1
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS flash_sale_products_view');
    }
};
