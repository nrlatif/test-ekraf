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
        Schema::table('catalogs', function (Blueprint $table) {
            // Make legacy fields nullable since we now use many-to-many relationship with products
            $table->string('product_name')->nullable()->change();
            $table->decimal('price', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogs', function (Blueprint $table) {
            // Reverse the changes - make fields required again
            $table->string('product_name')->nullable(false)->change();
            $table->decimal('price', 12, 2)->nullable(false)->change();
        });
    }
};
