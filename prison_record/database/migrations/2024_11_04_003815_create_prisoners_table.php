<?php

use App\Enums\PrisonerStatus;
use App\Enums\SecurityLevel;
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
        Schema::create('prisoners', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Set the engine to InnoDB
            $table->id();

            // Personal Information
            $table->string('prisoner_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->date('date_of_birth');
            $table->enum('sex', ['male', 'female']);

            // Case Information
            $table->date('admission_date');
            $table->date('release_date')->nullable();
            $table->string('cell_block');
            $table->string('cell_number');

            // Security Information
            $table->enum('status', array_column(PrisonerStatus::cases(), 'value'))
                ->default(PrisonerStatus::ACTIVE->value);
            $table->text('status_note')->nullable();
            $table->enum('security_level', array_column(SecurityLevel::cases(), 'value'))
                ->default(SecurityLevel::MINIMUM->value);

            // Additional Information
            $table->text('medical_conditions')->nullable();
            $table->text('current_medications')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('relationship')->nullable();
            $table->string('photo_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prisoners');
    }
};
