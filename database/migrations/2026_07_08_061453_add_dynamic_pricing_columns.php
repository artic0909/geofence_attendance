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
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('price_per_employee', 10, 2)->default(0)->after('price');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('employee_count')->nullable()->after('plan_id');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('employee_count')->nullable()->after('plan_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('price_per_employee');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('employee_count');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('employee_count');
        });
    }
};
