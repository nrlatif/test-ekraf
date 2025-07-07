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
        Schema::table('products', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkannya
            if (!Schema::hasColumn('products', 'sub_sector_id')) {
                $table->unsignedBigInteger('sub_sector_id')->nullable()->after('business_category_id');

                // Menambahkan foreign key constraint dengan nama yang unik
                $table->foreign('sub_sector_id', 'fk_products_sub_sector_id')
                      ->references('id')
                      ->on('sub_sectors')
                      // Mengatur ke NULL jika subsektor dihapus, karena kolomnya nullable
                      ->onDelete('set null')
                      ->onUpdate('cascade');

                // Menambahkan index
                $table->index('sub_sector_id', 'products_sub_sector_id_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cek apakah kolomnya ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('products', 'sub_sector_id')) {
                // Hapus foreign key dan index terlebih dahulu
                $table->dropForeign('fk_products_sub_sector_id');
                $table->dropIndex('products_sub_sector_id_index');
                $table->dropColumn('sub_sector_id');
            }
        });
    }
};
