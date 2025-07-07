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
    Schema::table('business_categories', function (Blueprint $table) {
        // Cek dan tambahkan kolom 'sub_sector_id' jika belum ada
        if (!Schema::hasColumn('business_categories', 'sub_sector_id')) {
            $table->unsignedBigInteger('sub_sector_id')->after('image');
        }

        // Cek dan tambahkan kolom 'description' jika belum ada
        if (!Schema::hasColumn('business_categories', 'description')) {
            $table->text('description')->nullable()->after('sub_sector_id');
        }

        // Cek dan tambahkan kolom timestamps jika belum ada
        if (!Schema::hasColumn('business_categories', 'created_at')) {
            $table->timestamps();
        }

        // Tambahkan foreign key constraint
        $table->foreign('sub_sector_id', 'business_categories_sub_sector_id_foreign')
              ->references('id')
              ->on('sub_sectors')
              ->onDelete('cascade')
              ->onUpdate('no action');

        // Tambahkan index
        $table->index('sub_sector_id', 'business_categories_sub_sector_id_index');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_categories', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign('business_categories_sub_sector_id_foreign');

            // Menghapus index
            $table->dropIndex('business_categories_sub_sector_id_index');

            // Menghapus kolom
            $table->dropColumn(['sub_sector_id', 'description']);
        });
    }
};
