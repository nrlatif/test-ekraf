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
        Schema::table('authors', function (Blueprint $table) {
            $table->string('avatar')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });

        // Update other tables that might have image fields
        if (Schema::hasTable('artikels')) {
            Schema::table('artikels', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->change();
            });
        }

        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->string('image')->nullable()->change();
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image')->nullable()->change();
            });
        }

        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                $table->string('image')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('avatar')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
        });

        if (Schema::hasTable('artikels')) {
            Schema::table('artikels', function (Blueprint $table) {
                $table->string('thumbnail')->nullable(false)->change();
            });
        }

        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->string('image')->nullable(false)->change();
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('image')->nullable(false)->change();
            });
        }

        if (Schema::hasTable('catalogs')) {
            Schema::table('catalogs', function (Blueprint $table) {
                $table->string('image')->nullable(false)->change();
            });
        }
    }
};
