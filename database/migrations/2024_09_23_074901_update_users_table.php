<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan kolom yang ada di gambar
        $table->string('full_name', 250)->nullable();
        $table->integer('company_id')->nullable();
        $table->string('user_database', 50)->nullable();
        $table->tinyInteger('user_status')->default(0);
        $table->integer('user_group_id')->nullable();
        $table->integer('user_type_id')->default(0);
        $table->integer('product_id')->nullable();
        $table->integer('salesman_id')->nullable();
        $table->integer('customer_id')->nullable();
        $table->integer('item_picture')->nullable();
        $table->tinyInteger('keep_status')->default(0);
        $table->tinyInteger('reseller_status')->default(0);
        $table->tinyInteger('change_price')->default(0);
        $table->tinyInteger('item_discount')->default(0);
        $table->tinyInteger('customer_status')->default(0);
        $table->tinyInteger('delivery_status')->default(0);
        $table->tinyInteger('receivable_status')->default(0);
        $table->tinyInteger('sales_order_status')->default(0);
        $table->string('printer_address', 50)->nullable();
        $table->tinyInteger('sync_status')->default(0);
        $table->date('sync_date')->nullable();
        $table->string('item_category_name', 20)->nullable();
        $table->integer('item_stock')->default(0);
        $table->integer('branch_id')->nullable();
        $table->tinyInteger('branch_status')->default(0);
        $table->tinyInteger('resto_status')->default(0);
        $table->tinyInteger('kitchen_status')->default(0);
        $table->integer('division_id')->nullable();
        $table->bigInteger('merchant_id')->nullable();
        $table->integer('warehouse_id')->nullable();
        $table->decimal('user_level', 4, 1)->default(0);
        $table->string('user_token', 250)->nullable();
        $table->enum('log_stat', ['on', 'off'])->nullable();
        $table->text('avatar')->nullable();
        $table->integer('school_period_id')->default(0);
        $table->string('school_period_semester', 10)->nullable();
        $table->integer('teacher_id')->nullable();
        $table->enum('data_state', ['0', '1'])->default('0');
        $table->integer('created_id')->nullable();
        $table->integer('updated_id')->nullable();
        $table->integer('deleted_id')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
