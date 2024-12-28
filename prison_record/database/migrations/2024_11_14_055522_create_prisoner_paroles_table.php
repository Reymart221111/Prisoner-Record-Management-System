<?php

use App\Enums\ParoleStatus;
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
        Schema::create('prisoner_paroles', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->id();
            $table->foreignId('prisoner_id')->constrained('prisoners', 'id')->onDelete('cascade');
            $table->enum('parole_type', array_column(ParoleStatus::cases(), 'value'));
            $table->integer('sentence_reduction');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prisoner_paroles');
    }
};
