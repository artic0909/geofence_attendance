<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('geofence_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->timestamp('check_in')->nullable();
            $table->string('check_in_lat')->nullable();
            $table->string('check_in_lng')->nullable();
            $table->string('check_in_photo')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_lng')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->enum('status', ['present', 'absent', 'late'])->default('present');
            $table->timestamps();
            
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('attendances');
    }
};