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
        Schema::table('attendances', function (Blueprint $table) {
            $table->boolean('is_auto_checkout_trap')->default(false)->after('check_out_photo');
        });

        Schema::table('outside_attendances', function (Blueprint $table) {
            $table->boolean('is_auto_checkout_trap')->default(false)->after('check_out_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('is_auto_checkout_trap');
        });

        Schema::table('outside_attendances', function (Blueprint $table) {
            $table->dropColumn('is_auto_checkout_trap');
        });
    }
};
