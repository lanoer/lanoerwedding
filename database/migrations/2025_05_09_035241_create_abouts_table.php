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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc_singkat');
            $table->text('desc_lengkap');
            $table->string('image')->nullable();
            $table->text('ourmission')->nullable();
            $table->text('ourvision')->nullable();
            $table->text('ourcommitment')->nullable();
            $table->string('complete_project')->nullable();
            $table->string('client_review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
