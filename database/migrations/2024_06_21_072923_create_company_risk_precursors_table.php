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
        Schema::create('company_risk_precursors', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->foreignId('company_risk_id')->constrained()->onDelete('cascade');
            $table->integer('status')->default(0)->comment('0: Normal, 1: Warning, 2: Dangerous');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_risk_precursors');
    }
};
