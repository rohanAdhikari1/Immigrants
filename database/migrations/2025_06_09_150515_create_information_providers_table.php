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
        Schema::create('information_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('relation_to_hr')->nullable();
            $table->string('ethinic_group')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('religion')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_providers');
    }
};
