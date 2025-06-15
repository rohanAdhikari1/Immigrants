<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnedMigrantWorker extends Model
{
    protected $fillable = [
        'household_id',
        'information_provider_id',
        'name',
        'number_of_person',
        'age',
        'gender',
        'contact_no',
        'relation_to_hr',
        'education_detail',
        'maritial_status',
        'foreign_country',
        'years_since_returned',
        'reason_for_returning_from_foreign_employment',
        'disability_or_incapacity_due_to_foreign_employment',
        'type_of_work_done_abroad',
        'work_experience_during_foreign_employment',
        'skill_training_after_return_to_nepal',
        'current_occupation',
        'type_of_own_business',
        'challenges_in_starting_new_business',
        'intention_to_return_to_foreign_employment',
        'desired_or_current_work_area_in_nepal',
        'requirements_for_employment_in_nepal', //20

        'post_foreign_employment_family_issues',
        'post_foreign_employment_family_issues_type',
        'post_foreign_employment_family_issues_type_other',
        'post_foreign_employment_health_issues',
        'post_foreign_employment_health_issues_type',
        'post_foreign_employment_health_issues_type_other',
        'post_foreign_employment_social_or_family_accusations',
        'post_foreign_employment_social_or_family_accusations_type',

        'latitude',
        'longitude',
        'municipality_id',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function household()
    {
        return $this->belongsTo(Household::class, 'household_id');
    }
    public function informationProvider()
    {
        return $this->belongsTo(InformationProvider::class, 'information_provider_id');
    }
    public function municipality()
    {
        return $this->belongsTo(Muncipality::class, 'municipality_id');
    }
}
