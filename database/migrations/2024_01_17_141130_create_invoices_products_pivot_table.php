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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->foreignUuid('invoice_id');
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');
            $table->foreignUuid('products_id');
            $table->foreign('products_id')
                ->references('id')
                ->on('products');
            $table->integer('quantity')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products_pivot');
    }
};
