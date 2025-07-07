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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('image')->nullable()->after('title');
            $table->string('link_url')->nullable()->after('artikel_id');
            $table->boolean('is_active')->default(true)->after('link_url');
            $table->integer('sort_order')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['title', 'image', 'link_url', 'is_active', 'sort_order']);
        });
    }
};
