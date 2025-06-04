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
        Schema::create('insert_code_seos', function (Blueprint $table) {
            $table->id();
            $table->text('gsc')->nullable();
            $table->text('gtag_analytics_id')->nullable();
            $table->text('gtag_analytics')->nullable();
            $table->text('gtag_header')->nullable();
            $table->text('gtag_body')->nullable();
            $table->text('bing')->nullable();
            $table->text('yandex')->nullable();
            $table->text('pinterest')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insert_code_seos');
    }
};
