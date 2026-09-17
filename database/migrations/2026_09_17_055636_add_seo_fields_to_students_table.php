<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {

            // SEO Meta
            $table->string('seo_meta_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->text('seo_meta_keywords')->nullable();
            $table->string('seo_canonical')->nullable();

            // SEO Image
            $table->string('seo_meta_image')->nullable();

            // Open Graph
            $table->string('og_meta_title')->nullable();
            $table->text('og_meta_description')->nullable();
            $table->string('og_meta_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->dropColumn([
                'seo_meta_title',
                'seo_meta_description',
                'seo_meta_keywords',
                'seo_canonical',
                'seo_meta_image',
                'og_meta_title',
                'og_meta_description',
                'og_meta_image',
            ]);
        });
    }
};