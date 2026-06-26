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
        Schema::table('geofences', function (Blueprint $table) {
            $table->integer('tracking_radius')->nullable()->after('radius');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('geofences', function (Blueprint $table) {
            $table->dropColumn('tracking_radius');
        });
    }
};
