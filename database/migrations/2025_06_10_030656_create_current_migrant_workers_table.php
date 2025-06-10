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
            $table->foreignId('household_id')->nullable()->constrained('households')->onDelete('set null');
            $table->foreignId('information_provider_id')->nullable()->constrained('information_providers')->onDelete('set null');
            $table->string('name')->nullable();
            $table->integer('number_of_person')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('relation_to_hr')->nullable();
            $table->string('education_detail')->nullable();
            $table->string('maritial_status')->nullable();
            $table->string('foreign_country')->nullable();
            $table->string('number_of_times_fe')->nullable();
            $table->string('mode_of_travel')->nullable();
            $table->string('route_taken')->nullable();
            $table->string('visa_type')->nullable();
            $table->string('documents_left_on_home')->nullable();
            $table->boolean('skill_training_before_foreign_employment')->nullable();
            $table->boolean('received_information_or_counseling_before_foreign_employment')->nullable();
            $table->string('amount_paid_for_foreign_employment')->nullable();
            $table->string('major_source_of_amount_paid')->nullable();
            $table->string('current_job_abroad')->nullable();
            $table->boolean('problems_faced_during_foreign_employment')->nullable();
            $table->string('problems_faced_during_foreign_employment_type')->nullable();
            $table->boolean('family_problems_during_foreign_employment')->nullable();
            $table->string('family_problems_during_foreign_employment_type')->nullable();
            $table->string('second_marriage_done_by')->nullable();
            $table->boolean('only_elder_at_home_due_to_foreign_employment')->nullable();
            $table->boolean('is_children_sent_to_boarding_school_in_headquarters_or_other_city')->nullable();
            $table->string('children_sent_to_boarding_school_in_headquarters_or_other_city')->nullable();
            $table->boolean('is_amount_sent_at_home_last_1_year')->nullable();
            $table->string('reason_for_not_sending_money')->nullable();
            $table->string('times_money_sent_home_last_1_year')->nullable(); //25
            $table->string('amount_sent_home_last_1_year')->nullable(); //26
            $table->string('remittance_expenditure_last_1_year')->nullable(); //27
            $table->string('place_of_purchase_of_house_or_land_from_remittance')->nullable(); //28
            $table->string('place_of_saving_remittance')->nullable(); //29
            $table->string('place_of_receiving_money_from_abroad')->nullable(); //30

            $table->string('migration_plan_location')->nullable();
            $table->string('plan_after_return')->nullable();

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
        Schema::dropIfExists('current_migrant_workers');
    }
};
