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
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->foreignId('muncipality_id')->nullable()->constrained('muncipalities')->onDelete('set null');
            $table->integer('ward_no')->nullable();
            $table->string('toll_name')->nullable();
            $table->string('toll_no')->nullable();
            $table->string('house_no')->nullable();
            $table->string('visit_date')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('house_representative_name')->nullable();
            $table->enum('house_represent_gender', ['male', 'female', 'other'])->nullable();
            $table->string('house_represent_contact_no')->nullable();
            $table->string('house_represent_occupation')->nullable();
            $table->integer('family_member_count')->nullable();
            $table->integer('family_members_male_count')->nullable();
            $table->integer('family_members_female_count')->nullable();
            $table->integer('family_members_other_count')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
