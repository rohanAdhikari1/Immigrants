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
        Schema::create('migrant_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_representative_id')->constrained('house_representatives')->onDelete('cascade');
            $table->string('type');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('caste')->nullable();
            $table->string('maritial_status')->nullable();

            // Common migration details
            $table->string('migrated_country')->nullable();
            $table->integer('migrated_times')->nullable();
            $table->string('foreign_occupation')->nullable();
            $table->string('home_contact_times')->nullable();
            $table->boolean('is_skilled')->nullable();
            $table->string('skilled_occupation')->nullable();
            $table->boolean('have_communication_permission')->nullable();
            $table->string('communication_permission_method')->nullable();

            // Documents and travel
            $table->boolean('have_document_in_home')->nullable();
            $table->string('document_type')->nullable();
            $table->string('travel_method')->nullable();
            $table->string('travel_road')->nullable();
            $table->string('travel_fee')->nullable();

            // Financial details
            $table->string('expense_source_abroad')->nullable();
            $table->string('loan_taken_from')->nullable();
            $table->string('interest_rate_on_loan')->nullable();
            $table->boolean('is_loan_fully_repaid')->nullable();
            $table->string('loan_repayment_duration')->nullable();
            $table->string('total_foreign_income')->nullable();
            $table->string('remittance_method')->nullable();
            $table->boolean('is_remittance_saved')->nullable();
            $table->string('remittance_saving_method')->nullable();
            $table->string('remittance_spend_source')->nullable();

            // COVID-specific details
            $table->boolean('have_covid_related_problem')->nullable();
            $table->string('covid_problem_type')->nullable();
            $table->boolean('covid_health_issue')->nullable();
            $table->string('covid_health_issue_type')->nullable();
            $table->boolean('is_salary_changed_due_to_covid')->nullable();
            $table->string('salary_change')->nullable();
            $table->string('remittance_before_covid')->nullable();
            $table->integer('previous_year_remittance_count')->nullable();
            $table->string('previous_year_remittance_amount')->nullable();

            // Return-specific details
            $table->integer('total_family_returned')->nullable();
            $table->integer('total_family_returned_male')->nullable();
            $table->integer('total_family_returned_female')->nullable();
            $table->integer('total_family_returned_other')->nullable();
            $table->string('home_returned_after')->nullable();
            $table->string('home_return_reason')->nullable();
            $table->boolean('want_to_go_again')->nullable();

            // Employment and skills
            $table->boolean('is_employed')->nullable();
            $table->string('employed_as')->nullable();
            $table->string('occupation_now')->nullable();
            $table->string('skill_before_migration')->nullable();
            $table->boolean('know_skill_test')->nullable();
            $table->boolean('have_know_skill_test')->nullable();
            $table->boolean('want_to_skill_test')->nullable();

            // Business and plans
            $table->boolean('plan_to_business')->nullable();
            $table->string('business_plan')->nullable();
            $table->boolean('doing_business')->nullable();
            $table->string('current_business')->nullable();
            $table->integer('employees_on_current_business')->nullable();
            $table->string('business_help_government')->nullable();
            $table->string('want_help_type_from_business')->nullable();
            $table->string('difficulties_to_start_business')->nullable();
            $table->boolean('plan_after_return')->nullable();
            $table->boolean('is_land_purchased')->nullable();
            $table->string('land_purchased_location')->nullable();
            $table->boolean('have_plan_to_migrate')->nullable();
            $table->string('migration_plan_location')->nullable();

            // Other details
            $table->boolean('faced_problems_abroad')->nullable();
            $table->string('problem_type')->nullable();
            $table->boolean('home_problem')->nullable();
            $table->string('home_problem_type')->nullable();
            $table->boolean('is_remarried')->nullable();
            $table->string('remarried_gender')->nullable();
            $table->boolean('is_elder_only_home')->nullable();
            $table->boolean('is_children_out_for_study')->nullable();
            $table->string('children_study_location')->nullable();
            $table->boolean('is_other_member_also_on_foreign')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_migrant_workers');
    }
};
