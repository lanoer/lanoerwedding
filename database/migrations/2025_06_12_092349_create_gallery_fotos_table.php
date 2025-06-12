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
        Schema::create('gallery_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('gallery_name');
            $table->string('image')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->integer('ordering')->default(10000);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_fotos');
    }
};
