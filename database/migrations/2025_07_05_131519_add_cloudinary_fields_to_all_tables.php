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
        // Add cloudinary fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('image');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });

        // Add cloudinary fields to authors table
        Schema::table('authors', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('avatar');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });

        // Add cloudinary fields to artikels table
        Schema::table('artikels', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('thumbnail');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });

        // Add cloudinary fields to banners table
        Schema::table('banners', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('image');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });

        // Add cloudinary fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('image');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });

        // Add cloudinary fields to catalogs table
        Schema::table('catalogs', function (Blueprint $table) {
            $table->string('cloudinary_id')->nullable()->after('image');
            $table->json('cloudinary_meta')->nullable()->after('cloudinary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove cloudinary fields from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });

        // Remove cloudinary fields from authors table
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });

        // Remove cloudinary fields from artikels table
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });

        // Remove cloudinary fields from banners table
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });

        // Remove cloudinary fields from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });

        // Remove cloudinary fields from catalogs table
        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn(['cloudinary_id', 'cloudinary_meta']);
        });
    }
};
