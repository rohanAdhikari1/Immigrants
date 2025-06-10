<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrentMigrantWorker;
use App\Models\Household;
use App\Models\InformationProvider;
use App\Models\Muncipality;
use App\Models\ReturnedMigrantWorker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate([
            //step first
            'type' => 'required',
            'house_representative_name' => 'required',
            'house_representative_gender' => 'nullable',
            'house_representative_contact_no' => 'nullable',
            'house_representative_occupation' => 'nullable',
            'family_memeber_count' => 'nullable|numeric',
            'family_members_male_count' => 'nullable|numeric',
            'family_members_female_count' => 'nullable|numeric',
            'family_members_other_count' => 'nullable|numeric',
            'family_migration_count' => 'nullable|numeric',
            'family_members_migration_male_count' => 'nullable|numeric',
            'family_members_migration_female_count' => 'nullable|numeric',
            'family_members_migration_other_count' => 'nullable|numeric',
            'ward_no' => 'nullable|numeric',
            'house_no' => 'nullable|numeric',
            'information_provider_name' => 'nullable',
            'ip_relation_to_hr' => 'nullable',
            'information_provider_caste' => 'nullable',
            'information_provider_mother_tongue' => 'nullable',
            'religion' => 'nullable',
            'toll_name' => 'nullable',
            'toll_no' => 'nullable',
            'created_at' => 'nullable',


            ///current migrant worker
            //part 1
            'name' => 'required',
            'gender' => 'required',
            'age' => 'numeric',
            'marital_status' =>  'nullable',
            'migrated_country' => 'nullable',
            'relation_to_hr' => 'nullable',
            'migrated_times' => 'nullable|numeric',
            'education_status' => 'nullable',


            //part 2
            'travel_method' => 'nullable',
            'travel_road' => 'nullable',
            'visa_type' => 'nullable',
            'is_skilled' => 'boolean|nullable',
            'have_communication_permission' => 'boolean|nullable',
            'have_document_in_home' => 'boolean|nullable',
            'fe_fee' => 'nullable',
            'fe_fee_paid_method' => 'nullable',
            //part 3
            'foreign_occupation' => 'nullable',
            'faced_problems_abroad' => 'boolean|nullable',
            'home_problem' => 'boolean|nullable',
            'problem_type' => 'nullable',
            'home_problem_type' => 'nullable',
            //part 5
            'remarried_gender' => 'nullable',
            'is_elder_only_home' => 'boolean|nullable',
            'is_children_out_for_study' => 'boolean|nullable',
            'children_out_for_study' => 'nullable',
            'have_send_money' => 'boolean|nullable',
            'money_not_send_problem' => 'nullable',
            'remittance_count' => 'nullable',
            'remittance_amount' => 'nullable',
            //part 6
            'remittance_spend_source' => 'nullable',
            'land_purchased' => 'boolean|nullable',
            'land_purchased_location' => 'nullable',
            'remittance_saving_method' => 'nullable',
            'migration_plan_location' => 'nullable',
            'plan_after_return' => 'nullable',
            'remittance_collect_method' => 'nullable',


            //return migrant worker
            //part 1
            'name' => 'nullable',
            'age' => 'nullable|numeric',
            'gender' => 'nullable',
            'contact_no' => 'nullable',
            'relation_to_hr' => 'nullable',
            'education_status' => 'nullable',
            'marital_status' => 'nullable',
            'migrated_country' => 'nullable',
            'home_returned_after' => 'nullable',
            'home_returned_after_duration' => 'nullable',
            'home_return_reason' => 'nullable',
            'total_family_returned_male' => 'nullable|numeric',
            'total_family_returned_female' => 'nullable|numeric',

            //part 2
            'want_to_go_again' => 'boolean|nullable',
            'is_disabled_on_foreign' => 'nullable',
            'work_on_foreign' => 'nullable',
            'work_exp_on_fe' => 'nullable',
            'skill_training_after_return' => 'nullable',
            'occupation_now' => 'nullable',
            'business_type' => 'nullable',

            //part 3
            'difficulties_to_start_business' => 'nullable',
            'desired_or_current_work_area_in_nepal' => 'nullable',
            'requirements_for_employment_in_nepal' => 'nullable',

            //part 4
            'post_foreign_employment_family_issues' => 'nullable|boolean',
            'post_foreign_employment_family_issues_type' => 'nullable',
            'post_foreign_employment_family_issues_type_other' => 'nullable',
            'post_foreign_employment_health_issues' => 'nullable|boolean',
            'post_foreign_employment_health_issues_type' => 'nullable',
            'post_foreign_employment_health_issues_type_other' => 'nullable',
            'post_foreign_employment_social_or_family_accusations' => 'nullable|boolean',
            'post_foreign_employment_social_or_family_accusations_type' => 'nullable',

            //location
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);
        if (Auth::user()->is_active) {
            DB::beginTransaction();
            try {
                $munciplaity = Muncipality::where('name', "")->pluck('id')->first();

                $houseHold = Household::create([
                    'muncipality_id' => $munciplaity,
                    'ward_no' => $validated['ward_no'],
                    'toll_name' => $validated['toll_name'],
                    'toll_no' => $validated['toll_no'],
                    'house_no' => $validated['house_no'],
                    'visit_date' => $validated['created_at'],
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                    'house_representative_name' => $validated['house_representative_name'],
                    'house_represent_gender' => $validated['house_representative_gender'],
                    'house_represent_contact_no' => $validated['house_representative_contact_no'],
                    'house_represent_occupation' => $validated['house_representative_occupation'],
                    'family_member_count' => $validated['family_memeber_count'],
                    'family_members_male_count' => $validated['family_members_male_count'],
                    'family_members_female_count' => $validated['family_members_female_count'],
                    'family_members_other_count' => $validated['family_members_other_count'],
                    'created_by' => Auth::id(),
                ]);
                $informationProvider = InformationProvider::create([
                    'name' => $validated['information_provider_name'],
                    'relation_to_hr' => $validated['ip_relation_to_hr'],
                    'ethinic_group' => $validated['information_provider_caste'],
                    'mother_tongue' => $validated['information_provider_mother_tongue'],
                    'religion' => $validated['religion'],
                    'created_by' => $validated['created_by']
                ]);

                if ($validated['type'] == 'current') {
                    CurrentMigrantWorker::create([
                        'household_id' => $houseHold->id,
                        'information_provider_id' => $informationProvider->id,

                        'name' => $validated['name'],
                        'gender' => $validated['gender'],
                        'age' => $validated['age'],
                        'marital_status' =>  $validated['marital_status'],
                        'foreign_country' => $validated['migrated_country'],
                        'relation_to_hr' => $validated['relation_to_hr'],
                        'number_of_times_fe' => $validated['migrated_times'],
                        'education_detail' => $validated['education_status'],

                        'mode_of_travel' => $validated['travel_method'],
                        'route_taken' => $validated['travel_road'],
                        'visa_type' => $validated['visa_type'],
                        'documents_left_on_home' => $validated['have_document_in_home'],
                        'skill_training_before_foreign_employment' => $validated['is_skilled'],
                        'received_information_or_counseling_before_foreign_employment' => $validated['have_communication_permission'],
                        'amount_paid_for_foreign_employment' => $validated['fe_fee'],
                        'major_source_of_amount_paid' => $validated['fe_fee_paid_method'],

                        'current_job_abroad' => $validated['foreign_occupation'],
                        'problems_faced_during_foreign_employment' => $validated['faced_problems_abroad'],
                        'problems_faced_during_foreign_employment_type' => $validated['problem_type'],
                        'family_problems_during_foreign_employment' => $validated['home_problem'],
                        'family_problems_during_foreign_employment_type' => $validated['home_problem_type'],

                        'second_marriage_done_by' => $validated['remarried_gender'],
                        'only_elder_at_home_due_to_foreign_employment' => $validated['is_elder_only_home'],
                        'is_children_sent_to_boarding_school_in_headquarters_or_other_city' => $validated['is_children_out_for_study'],
                        'children_sent_to_boarding_school_in_headquarters_or_other_city' => $validated['children_out_for_study'],
                        'is_amount_sent_at_home_last_1_year' => $validated['have_send_money'],
                        'reason_for_not_sending_money' => $validated['money_not_send_problem'],
                        'times_money_sent_home_last_1_year' => $validated['remittance_count'],
                        'amount_sent_home_last_1_year' => $validated['remittance_amount'],

                        'remittance_expenditure_last_1_year' => $validated['remittance_spend_source'],
                        'place_of_purchase_of_house_or_land_from_remittance' => $validated['land_purchased_location'],
                        'place_of_saving_remittance' => $validated['remittance_saving_method'],
                        'place_of_receiving_money_from_abroad' => $validated['remittance_collect_method'],

                        'migration_plan_location' => $validated['migration_plan_location'],
                        'plan_after_return' => $validated['plan_after_return'],

                        'latitude' => $validated['latitude'],
                        'longitude' => $validated['longitude'],
                        'municipality_id' => $munciplaity,
                        'created_by' => Auth::id(),
                    ]);
                } else {
                    ReturnedMigrantWorker::create([
                        'household_id' => $houseHold->id,
                        'information_provider_id' => $informationProvider->id,

                        'name' => $validated['name'],
                        'number_of_person' => $validated['total_family_returned_male'] + $validated['total_family_returned_female'],
                        'age' => $validated['age'],
                        'gender' => $validated['gender'],
                        'contact_no' => $validated['contact_no'],
                        'relation_to_hr' => $validated['relation_to_hr'],
                        'education_detail' => $validated['education_status'],
                        'maritial_status' => $validated['marital_status'],
                        'foreign_country' => $validated['migrated_country'],
                        'years_since_returned' => $validated['home_returned_after'] . ' ' . $validated['home_returned_after_duration'],
                        'reason_for_returning_from_foreign_employment' => $validated['home_return_reason'],

                        'disability_or_incapacity_due_to_foreign_employment' => $validated['is_disabled_on_foreign'],
                        'type_of_work_done_abroad' => $validated['work_on_foreign'],
                        'work_experience_during_foreign_employment' => $validated['work_exp_on_fe'],
                        'skill_training_after_return_to_nepal' => $validated['skill_training_after_return'],
                        'current_occupation' => $validated['occupation_now'],
                        'type_of_own_business' => $validated['business_type'],

                        'challenges_in_starting_new_business' => $validated['difficulties_to_start_business'],
                        'intention_to_return_to_foreign_employment' => $validated['want_to_go_again'],
                        'desired_or_current_work_area_in_nepal' => $validated['desired_or_current_work_area_in_nepal'],
                        'requirements_for_employment_in_nepal' => $validated['requirements_for_employment_in_nepal'],

                        'post_foreign_employment_family_issues' => $validated['post_foreign_employment_family_issues'],
                        'post_foreign_employment_family_issues_type' => $validated['post_foreign_employment_family_issues_type'],
                        'post_foreign_employment_family_issues_type_other' => $validated['post_foreign_employment_family_issues_type_other'],
                        'post_foreign_employment_health_issues' => $validated['post_foreign_employment_health_issues'],
                        'post_foreign_employment_health_issues_type' => $validated['post_foreign_employment_health_issues_type'],
                        'post_foreign_employment_health_issues_type_other' => $validated['post_foreign_employment_health_issues_type_other'],
                        'post_foreign_employment_social_or_family_accusations' => $validated['post_foreign_employment_social_or_family_accusations'],
                        'post_foreign_employment_social_or_family_accusations_type' => $validated['post_foreign_employment_social_or_family_accusations_type'],

                        'latitude' => $validated['latitude'],
                        'longitude' => $validated['longitude'],
                        'municipality_id' => $munciplaity,
                        'created_by' => Auth::id(),
                    ]);
                }

                DB::commit();
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Data Synced Sucessfully'
                    ],
                    200
                );
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage() ?? 'Something went wrong! Please try again later'], 500);
            }
        }
        return response()->json(['message' => 'Your account is deactivated by administrator. Please contact administrator for further process.'], 500);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'house_representative_name' => 'required',
    //         'house_representative_gender' => 'required',
    //         'house_representative_contact_no' => 'required',
    //         'house_representative_occupation' => 'nullable',
    //         'house_representative_address' => 'nullable',
    //         'family_memeber_count' => 'required|numeric',
    //         'family_members_male_count' => 'required|numeric',
    //         'family_members_female_count' => 'required|numeric',
    //         'family_members_other_count' => 'required|numeric',
    //         'family_migration_count' => 'required|numeric',
    //         'family_members_migration_male_count' => 'required|numeric',
    //         'family_members_migration_female_count' => 'required|numeric',
    //         'family_members_migration_other_count' => 'required|numeric',
    //         'ward_no' => 'required|numeric',
    //         'address_1' => 'nullable',
    //         'address_2' => 'nullable',
    //         'house_no' => 'nullable',

    //         'name' => 'required',
    //         'gender' => 'required',
    //         'age' => 'required|numeric',
    //         'contact_no' => 'required',
    //         'caste' => 'required',
    //         'maritial_status' => 'required',

    //         'total_family_returned' => 'required|numeric',
    //         'total_family_returned_male' => 'required|numeric',
    //         'total_family_returned_female' => 'required|numeric',
    //         'total_family_returned_other' => 'required|numeric',

    //         'migrated_country' => 'required',
    //         'home_returned_after' => 'nullable',
    //         'home_return_reason' => 'nullable',
    //         'want_to_go_again'  => 'boolean|nullable',
    //         'occupation_now' => 'nullable',

    //         'is_employed' => 'boolean|nullable',
    //         'employed_as' => 'nullable',
    //         'skill_before_migration' => 'nullable',
    //         'skilled_occupation' => 'nullable',
    //         'know_skill_test' => 'boolean|nullable',
    //         'have_know_skill_test' => 'boolean|nullable',
    //         'want_to_skill_test' => 'boolean|nullable',
    //         'foreign_income_used_for' => 'nullable',
    //         'saved_foriegn_income' => 'nullable',
    //         'plan_to_business' => 'nullable|boolean',
    //         'business_plan' => 'nullable',
    //         'doing_business' => 'nullable',
    //         'current_business' => 'nullable',
    //         'emplyees_on_current_business' => 'nullable|numeric',
    //         'business_help_government' => 'nullable',
    //         'want_help_type_from_business' => 'nullable',
    //         'difficulties_to_start_business' => 'nullable',
    //     ]);
    //     if (Auth::user()->is_active) {
    //         DB::beginTransaction();
    //         try {
    //             $munciplaity = Muncipality::where('name', "")->pluck('id')->first();
    //             HouseRepresentative::create([
    //                 'name' => $validated['house_representative_name'],
    //                 'gender' => $validated['house_representative_gender'],
    //                 'contact_no' => $validated['house_representative_contact_no'],
    //                 'occupation' => $validated['house_representative_occupation'],
    //                 'address' => $validated['house_representative_address'],
    //                 'family_memeber_count' => $validated['family_memeber_count'],
    //                 'family_members_male_count' => $validated['family_members_male_count'],
    //                 'family_members_female_count' => $validated['family_members_female_count'],
    //                 'family_members_other_count' => $validated['family_members_other_count'],
    //                 'family_migration_count' => $validated['family_migration_count'],
    //                 'family_members_migration_male_count' => $validated['family_members_migration_male_count'],
    //                 'family_members_migration_female_count' => $validated['family_members_migration_female_count'],
    //                 'family_members_migration_other_count' => $validated['family_members_migration_other_count'],
    //                 'muncipality_id' => $munciplaity,
    //                 'ward_no' => $validated['ward_no'],
    //                 'address_1' => $validated['address_1'],
    //                 'address_2' => $validated['address_2'],
    //                 'house_no' => $validated['house_no'],
    //             ]);

    //             CurrentMigrantWorker::create([
    //                 'name' => $validated['name'],
    //                 'gender' => $validated['gender'],
    //                 'age' => $validated['age'],
    //                 'contact_no' => $validated['contact_no'],
    //                 'caste' => $validated['caste'],
    //                 'maritial_status' => $validated['maritial_status'],
    //                 'total_family_returned' => $validated['total_family_returned'],
    //                 'total_family_returned_male' => $validated['total_family_returned_male'],
    //                 'total_family_returned_female' => $validated['total_family_returned_female'],
    //                 'total_family_returned_other' => $validated['total_family_returned_other'],
    //                 'migrated_country' => $validated['migrated_country'],
    //                 'home_returned_after' => $validated['home_returned_after'],
    //                 'home_return_reason' => $validated['home_return_reason'],
    //                 'want_to_go_again'  => $validated['want_to_go_again'],
    //                 'occupation_now' => $validated['occupation_now'],
    //                 'is_employed' => $validated['is_employed'],
    //                 'employed_as' => $validated['employed_as'],
    //                 'skill_before_migration' => $validated['skill_before_migration'],
    //                 'skilled_occupation' => $validated['skilled_occupation'],
    //                 'know_skill_test' => $validated['know_skill_test'],
    //                 'have_know_skill_test' => $validated['have_know_skill_test'],
    //                 'want_to_skill_test' => $validated['want_to_skill_test'],
    //                 'foreign_income_used_for' => $validated['foreign_income_used_for'],
    //                 'saved_foriegn_income' => $validated['saved_foriegn_income'],
    //                 'plan_to_business' => $validated['plan_to_business'],
    //                 'business_plan' => $validated['business_plan'],
    //                 'doing_business' => $validated['doing_business'],
    //                 'current_business' => $validated['current_business'],
    //                 'emplyees_on_current_business' => $validated['emplyees_on_current_business'],
    //                 'business_help_government' => $validated['business_help_government'],
    //                 'want_help_type_from_business' => $validated['want_help_type_from_business'],
    //                 'difficulties_to_start_business' => $validated['difficulties_to_start_business'],
    //             ]);

    //             DB::commit();
    //             return response()->json(
    //                 [
    //                     'status' => true,
    //                     'message' => 'Data Synced Sucessfully'
    //                 ],
    //                 200
    //             );
    //         } catch (Exception $e) {
    //             DB::rollBack();
    //             return response()->json(['message' => $e->getMessage() ?? 'Something went wrong! Please try again later'], 500);
    //         }
    //     }
    //     return response()->json(['message' => 'Your account is deactivated by administrator. Please contact administrator for further process.'], 500);
    // }

    // $validated = $request->validate([
    //     'famer_phone' => 'nullable|numeric',
    //     'farmer_registration_no' => 'required|numeric',
    //     'famer_name' => 'required',
    //     // 'farmer_ward' => [
    //     //     'required',
    //     //     function ($attribute, $value, $fail) {
    //     //         $nepaliToEnglishMap = [
    //     //             '०' => '0',
    //     //             '१' => '1',
    //     //             '२' => '2',
    //     //             '३' => '3',
    //     //             '४' => '4',
    //     //             '५' => '5',
    //     //             '६' => '6',
    //     //             '७' => '7',
    //     //             '८' => '8',
    //     //             '९' => '9'
    //     //         ];
    //     //         if (preg_match('/[०-९]/', $value)) {
    //     //             $value = strtr($value, $nepaliToEnglishMap);
    //     //         }
    //     //         if (!is_numeric($value)) {
    //     //             $fail($attribute . ' must be a valid number.');
    //     //         }
    //     //     }
    //     // ],
    // ]);
}
