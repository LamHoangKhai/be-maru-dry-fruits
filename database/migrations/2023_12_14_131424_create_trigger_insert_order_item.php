<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER insertOrderItem
        BEFORE INSERT ON order_items
        FOR EACH ROW
        BEGIN
            DECLARE updated_quantity DECIMAL(10, 2);
            SET updated_quantity = CAST(NEW.weight AS DECIMAL(10, 2)) / 1000 * NEW.quantity;
            UPDATE products
                SET products.store_quantity = products.store_quantity - updated_quantity
            WHERE products.id = NEW.product_id;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
