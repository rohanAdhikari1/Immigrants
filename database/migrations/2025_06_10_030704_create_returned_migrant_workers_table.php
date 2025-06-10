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
        Schema::create('returned_migrant_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->nullable()->constrained('households')->onDelete('set null');
            $table->foreignId('information_provider_id')->nullable()->constrained('information_providers')->onDelete('set null');
            $table->string('name')->nullable();
            $table->integer('number_of_person')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('contact_no')->nullable();
            $table->string('relation_to_hr')->nullable();
            $table->string('education_detail')->nullable();
            $table->string('maritial_status')->nullable();
            $table->string('foreign_country')->nullable();
            $table->string('years_since_returned')->nullable();
            $table->string('reason_for_returning_from_foreign_employment')->nullable();
            $table->string('disability_or_incapacity_due_to_foreign_employment')->nullable();
            $table->string('type_of_work_done_abroad')->nullable();
            $table->string('work_experience_during_foreign_employment')->nullable();
            $table->string('skill_training_after_return_to_nepal')->nullable();
            $table->string('current_occupation')->nullable();
            $table->string('type_of_own_business')->nullable();
            $table->string('challenges_in_starting_new_business')->nullable();
            $table->boolean('intention_to_return_to_foreign_employment')->nullable();
            $table->string('desired_or_current_work_area_in_nepal')->nullable();
            $table->string('requirements_for_employment_in_nepal')->nullable(); //20

            $table->boolean('post_foreign_employment_family_issues')->nullable();
            $table->string('post_foreign_employment_family_issues_type')->nullable();
            $table->string('post_foreign_employment_family_issues_type_other')->nullable();
            $table->boolean('post_foreign_employment_health_issues')->nullable();
            $table->string('post_foreign_employment_health_issues_type')->nullable();
            $table->string('post_foreign_employment_health_issues_type_other')->nullable();
            $table->string('post_foreign_employment_social_or_family_accusations')->nullable();
            $table->string('post_foreign_employment_social_or_family_accusations_type')->nullable();

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignId('municipality_id')->nullable()->constrained('muncipalities')->onDelete('set null');

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returned_migrant_workers');
    }
};
