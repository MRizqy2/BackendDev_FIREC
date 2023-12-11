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
        Schema::create('forecast_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forecast_simulation_id')->constrained('forecast_simulations')->onDelete('cascade');
            $table->foreignId('forecast_transaction_type_id')->constrained('forecast_transaction_types');
            $table->foreignId('forecast_transaction_interval_id')->constrained('forecast_transaction_intervals');
            $table->string('name');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecast_transactions');
    }
};
