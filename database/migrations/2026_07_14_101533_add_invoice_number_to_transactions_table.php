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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->unique()->after('id');
        });

        // Backfill existing records safely without firing model events
        $transactions = \Illuminate\Support\Facades\DB::table('transactions')->get();
        foreach ($transactions as $transaction) {
            $date = date('ymd', strtotime($transaction->created_at ?? now()));
            $rand = strtoupper(\Illuminate\Support\Str::random(6));
            \Illuminate\Support\Facades\DB::table('transactions')
                ->where('id', $transaction->id)
                ->update(['invoice_number' => 'INV-' . $date . '-' . $rand]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('invoice_number');
        });
    }
};
