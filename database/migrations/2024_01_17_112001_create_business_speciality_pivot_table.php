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
        Schema::create('business_speciality', function (Blueprint $table) {
            $table->foreignUuid('business_id');
            $table->foreign('business_id')
                ->references('id')
                ->on('businesses');
            $table->foreignUuid('speciality_id');
            $table->foreign('speciality_id')
                ->references('id')
                ->on('specialities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_specialities_pivot');
    }
};
