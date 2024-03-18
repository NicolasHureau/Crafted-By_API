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
            $table->decimal('price', total: 12, places: 2);
            $table->foreignUuid('category_id');
            $table->foreignUuid('material_id');
            $table->foreignUuid('style_id');
            $table->foreignUuid('color_id');
            $table->foreignUuid('size_id');
            $table->integer('stock')->unsigned();
            $table->string('image');
            $table->boolean('active');
            $table->timestamps();
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->foreign('material_id')
                ->references('id')
                ->on('materials');
            $table->foreign('style_id')
                ->references('id')
                ->on('styles');
            $table->foreign('color_id')
                ->references('id')
                ->on('colors');
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes');
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
