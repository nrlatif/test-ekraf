<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // 1. Menambahkan kolom dan foreign key ke tabel 'products'
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('business_category_id')->nullable()->after('user_id');

            $table->foreign('business_category_id')
                  ->references('id')
                  ->on('business_categories');
        });

        // 2. Menambahkan foreign key ke tabel 'artikels'
        Schema::table('artikels', function (Blueprint $table) {
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Urutan dibalik dari method up()

        // 1. Mengembalikan perubahan pada tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->default(3)->change();
        });

        // 2. Menghapus foreign key dari tabel 'artikels'
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        // 3. Menghapus kolom dan foreign key dari tabel 'products'
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['business_category_id']);
            $table->dropColumn('business_category_id');
        });
    }
};
