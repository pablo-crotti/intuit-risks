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
        Schema::create('organization_type_risk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_type_id')->constrained('organization_types')->onDelete('cascade');
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_type_risk');
    }
};
