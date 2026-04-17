<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('outside_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->timestamp('check_in')->nullable();
            $table->string('check_in_lat')->nullable();
            $table->string('check_in_lng')->nullable();
            $table->string('check_in_photo')->nullable();
            $table->string('checkin_location')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_lng')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->string('checkout_location')->nullable();
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->timestamps();
            
            // Allow multiple outside attendances per day if needed, or unique per session?
            // Usually outside work might happen multiple times. So I won't add the unique constraint on date.
            // Or should I? The user said "all this are same as attendances table". 
            // In attendances table, they had: $table->unique(['employee_id', 'date']);
            // If they can only have ONE outside session per day, I'll add it.
            // Actually, if it's for "purchasing something", they might do it once or multiple times.
            // But let's stick to the "same as attendances" requirement for simplicity unless asked otherwise.
            // Wait, if I make it unique by date, they can't have both regular and outside attendance if the system expects only one record.
            // But regular attendance is in 'attendances' table.
        });
    }

    public function down(): void {
        Schema::dropIfExists('outside_attendances');
    }
};
