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
        Schema::create('house_representatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('contact_no')->nullable();
            $table->string('occupation')->nullable();
            $table->string('address')->nullable();
            $table->integer('family_memeber_count')->nullable();
            $table->integer('family_members_male_count')->nullable();
            $table->integer('family_members_female_count')->nullable();
            $table->integer('family_members_other_count')->nullable();
            $table->integer('family_migration_count')->nullable();
            $table->integer('family_members_migration_male_count')->nullable();
            $table->integer('family_members_migration_female_count')->nullable();
            $table->integer('family_members_migration_other_count')->nullable();
            $table->foreignId('muncipality_id')->nullable()->constrained('muncipalities')->onDelete('set null');
            $table->integer('ward_no')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('house_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_representatives');
    }
};
