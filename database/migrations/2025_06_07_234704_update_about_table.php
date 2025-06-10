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
        Schema::table('abouts', function (Blueprint $table) {
            // Menghapus kolom lama
            $table->dropColumn([
                'desc_singkat',
                'desc_lengkap',
                'ourmission',
                'ourvision',
                'ourcommitment',
                'complete_project',
                'client_review'
            ]);

            // Menambah kolom baru
            $table->string('slug')->unique()->nullable()->after('title'); // Deskripsi umum
            $table->text('description')->nullable()->after('slug'); // Deskripsi umum
            $table->text('meta_description')->nullable()->after('description'); // Meta description
            $table->text('meta_keywords')->nullable()->after('meta_description'); // Meta keywords
            $table->string('image_alt_text')->nullable()->after('meta_keywords'); // Alt text untuk gambar
            $table->text('meta_tags')->nullable()->after('image_alt_text'); // Meta tags
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            // Mengembalikan kolom yang dihapus
            $table->text('desc_singkat');
            $table->text('desc_lengkap');
            $table->text('ourmission')->nullable();
            $table->text('ourvision')->nullable();
            $table->text('ourcommitment')->nullable();
            $table->string('complete_project')->nullable();
            $table->string('client_review')->nullable();

            // Menghapus kolom baru yang ditambahkan
            $table->dropColumn([
                'description',
                'meta_description',
                'meta_keywords',
                'image_alt_text',
                'meta_tags',
                'slug'
            ]);
        });
    }
};
