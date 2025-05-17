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
        Schema::create('current_migrant_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_representative_id')->constrained('house_representatives')->onDelete('cascade');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('caste')->nullable();
            $table->string('maritial_status')->nullable();
            $table->integer('total_family_returned')->nullable();
            $table->integer('total_family_returned_male')->nullable();
            $table->integer('total_family_returned_female')->nullable();
            $table->integer('total_family_returned_other')->nullable();
            $table->string('migrated_country')->nullable();
            $table->string('home_returned_after')->nullable();
            $table->string('home_return_reason')->nullable();
            $table->boolean('want_to_go_again')->nullable();
            $table->string('occupation_now')->nullable();
            $table->boolean('is_employed')->nullable();
            $table->string('employed_as')->nullable();
            $table->string('skill_before_migration')->nullable();
            $table->string('skilled_occupation')->nullable();
            $table->boolean('know_skill_test')->nullable();
            $table->boolean('have_know_skill_test')->nullable();
            $table->boolean('want_to_skill_test')->nullable();
            $table->string('foreign_income_used_for')->nullable();
            $table->string('saved_foriegn_income')->nullable();
            $table->boolean('plan_to_business')->nullable();
            $table->string('business_plan')->nullable();
            $table->boolean('doing_business')->nullable();
            $table->string('current_business')->nullable();
            $table->integer('emplyees_on_current_business')->nullable();
            $table->string('business_help_government')->nullable();
            $table->string('want_help_type_from_business')->nullable();
            $table->string('difficulties_to_start_business')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_migrant_workers');
    }
};
