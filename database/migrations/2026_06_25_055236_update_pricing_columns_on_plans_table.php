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
            $table->dropColumn(['monthly_price', 'yearly_price']);
            $table->decimal('price', 10, 2)->after('description')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->decimal('monthly_price', 8, 2)->after('description');
            $table->decimal('yearly_price', 8, 2)->after('monthly_price');
        });
    }
};
