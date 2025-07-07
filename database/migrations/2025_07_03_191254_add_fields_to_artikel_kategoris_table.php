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
        Schema::table('artikel_kategoris', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('slug');
            $table->text('description')->nullable()->after('icon');
            $table->string('color')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikel_kategoris', function (Blueprint $table) {
            $table->dropColumn(['icon', 'description', 'color']);
        });
    }
};
