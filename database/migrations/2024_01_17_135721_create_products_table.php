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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id');
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->foreignUuid('category_id');
            $table->foreignUuid('material_id');
            $table->foreignUuid('style_id');
            $table->foreignUuid('color_id');
            $table->foreignUuid('size_id');
            $table->integer('stock')->unsigned();
            $table->string('image');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
