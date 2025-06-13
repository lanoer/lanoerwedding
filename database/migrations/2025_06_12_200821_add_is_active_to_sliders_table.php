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
        Schema::table('sliders', function (Blueprint $table) {
            $table->boolean('isActive_slider')->default(true);
            $table->boolean('isActive_card')->default(true);
            $table->integer('ordering')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('isActive_slider');
            $table->dropColumn('isActive_card');
            $table->dropColumn('ordering');
        });
    }
};
