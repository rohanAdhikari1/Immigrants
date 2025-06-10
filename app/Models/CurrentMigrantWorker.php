<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentMigrantWorker extends Model
{
    protected $fillable = [
        'household_id',
        'information_provider_id',
        'name',
        'number_of_person',
        'age',
        'gender',
        'relation_to_hr',
        'education_detail',
        'maritial_status',
        'foreign_country',
        'number_of_times_fe',
        'mode_of_travel',
        'route_taken',
        'visa_type',
        'documents_left_on_home',
        'skill_training_before_foreign_employment',
        'received_information_or_counseling_before_foreign_employment',
        'amount_paid_for_foreign_employment',
        'major_source_of_amount_paid',
        'current_job_abroad',
        'problems_faced_during_foreign_employment',
        'problems_faced_during_foreign_employment_type',
        'family_problems_during_foreign_employment',
        'family_problems_during_foreign_employment_type',
        'second_marriage_done_by',
        'only_elder_at_home_due_to_foreign_employment',
        'children_sent_to_boarding_school_in_headquarters_or_other_city',
        'is_amount_sent_at_home_last_1_year',
        'reason_for_not_sending_money',
        'times_money_sent_home_last_1_year',
        'amount_sent_home_last_1_year',
        'remittance_expenditure_last_1_year',
        'place_of_purchase_of_house_or_land_from_remittance',
        'place_of_saving_remittance',
        'place_of_receiving_money_from_abroad',
        'migration_plan_location',
        'plan_after_return',
        'latitude',
        'longitude',
        'municipality_id',
        'created_by',
    ];
}
