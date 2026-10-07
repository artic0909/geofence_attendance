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
            if (!Schema::hasColumn('attendances', 'app_usages')) {
                $table->json('app_usages')->nullable()->after('status');
            }
        });

        Schema::table('outside_attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('outside_attendances', 'app_usages')) {
                $table->json('app_usages')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'app_usages')) {
                $table->dropColumn('app_usages');
            }
        });

        Schema::table('outside_attendances', function (Blueprint $table) {
            if (Schema::hasColumn('outside_attendances', 'app_usages')) {
                $table->dropColumn('app_usages');
            }
        });
    }
};
