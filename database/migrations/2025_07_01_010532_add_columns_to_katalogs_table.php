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
        Schema::table('katalogs', function (Blueprint $table) {
            $table->decimal('harga', 12, 2)->after('produk');
            $table->string('no_hp')->nullable()->after('content');
            $table->string('instagram')->nullable()->after('no_hp');
            $table->string('shopee')->nullable()->after('instagram');
            $table->string('tokopedia')->nullable()->after('shopee');
            $table->string('lazada')->nullable()->after('tokopedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalogs', function (Blueprint $table) {
            $table->dropColumn(['harga', 'no_hp', 'instagram', 'shopee', 'tokopedia', 'lazada']);
        });
    }
};
