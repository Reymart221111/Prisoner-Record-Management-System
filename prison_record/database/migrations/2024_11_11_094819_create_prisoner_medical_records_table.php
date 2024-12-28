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
        Schema::create('prisoner_medical_records', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->id();
            $table->foreignId('prisoner_id')->constrained('prisoners', 'id')->onDelete('cascade');
            $table->text('medical_diagnosis');
            $table->text('medication')->nullable();
            $table->date('last_checkup_date');
            $table->text('doctor_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prisoner_medical_records');
    }
};
