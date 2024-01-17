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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('history');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address');
            $table->integer('zip_code_id');
            $table->integer('city');
            $table->string('logo');
            $table->integer('theme_id');
            $table->timestamps();
            $table->foreign('zip_code_id')
                ->references('id')
                ->on('zip_code');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
            $table->foreign('theme_id')
                ->references('id')
                ->on('themes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
