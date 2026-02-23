<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->integer('km_awal');
            $table->integer('km_akhir')->nullable();
            $table->string('foto_awal');
            $table->string('foto_akhir')->nullable();
            $table->string('tujuan');
            $table->text('keperluan');
            $table->dateTime('jam_out');
            $table->dateTime('jam_in')->nullable();
            $table->enum('status', ['pending', 'approved', 'ongoing', 'completed', 'verified'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('trips');
    }
};