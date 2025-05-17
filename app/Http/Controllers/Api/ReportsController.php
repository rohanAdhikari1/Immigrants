<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrentMigrantWorker;
use App\Models\Farmer;
use App\Models\FarmerRecord;
use App\Models\FarmerVaccine;
use App\Models\FarmerVaccineRemark;
use App\Models\HouseRepresentative;
use App\Models\Muncipality;
use App\Models\ReturnMigrantWorker;
use App\Models\SessionYear;
use App\Models\Vaccine;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate([
            'house_representative_name' => 'required',
            'house_representative_gender' => 'required',
            'house_representative_contact_no' => 'required',
            'house_representative_occupation' => 'nullable',
            'house_representative_address' => 'nullable',
            'family_memeber_count' => 'required|numeric',
            'family_members_male_count' => 'required|numeric',
            'family_members_female_count' => 'required|numeric',
            'family_members_other_count' => 'required|numeric',
            'family_migration_count' => 'required|numeric',
            'family_members_migration_male_count' => 'required|numeric',
            'family_members_migration_female_count' => 'required|numeric',
            'family_members_migration_other_count' => 'required|numeric',
            'ward_no' => 'required|numeric',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'house_no' => 'nullable',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required|numeric',
            'contact_no' => 'required',
            'caste' => 'required',
            'maritial_status' =>  'required',
            'migrated_country' => 'required',
            'migrated_times' => 'required|numeric',
            'foreign_occupation' => 'nullable',
            'home_contact_times' => 'required',
            'is_skilled' => 'boolean|nullable',
            'skilled_occupation' => 'nullable',
            'have_coomunication_permission' => 'boolean|nullable',
            'communication_permission_method' => 'nullable',
            'have_document_in_home' => 'boolean|nullable',
            'document_type' => 'nullable',
            'travel_methoed' => 'nullable',
            'travel_road' => 'nullable',
            'travel_fee' => 'nullable',
            'expense_source_abroad' => 'nullable',
            'loan_taken_from' => 'nullable',
            'interest_rate_on_loan' => 'nullable',
            'is_loan_fully_repaid' => 'boolean|nullable',
            'loan_repayment_duration' => 'nullable',
            'faced_problems_abroad' => 'nullable',
            'problem_type' => 'nullable',
            'have_covid_related_problem' => 'boolean|nullable',
            'covid_problem_type' => 'nullable',
            'covid_health_issue' => 'boolean|nullable',
            'covid_health_issue_type' => 'nullable',
            'emergency_contact_number' => 'nullable',
            'home_problem' => 'boolean|nullable',
            'home_problem_type' => 'nullable',
            'is_remarried' => 'boolean|nullable',
            'remarried_gender' => 'nullable',
            'is_elder_only_home' => 'boolean|nullable',
            'is_childer_out_for_study' => 'boolean|nullable',
            'children_study_location' => 'nullable',
            'total_foreign_income' => 'nullable',
            'remittance_method' => 'nullable',
            'is_salary_changed_due_to_covid' => 'boolean|nullable',
            'salary_change' => 'nullable',
            'remeittance_before_covid' => 'nullable',
            'previous_year_remeittance_count' => 'nullable',
            'previous_year_remeittance_amount' => 'nullable',
            'remittance_spend_source' => 'nullable',
            'is_remittance_saved' => 'boolean|nullable',
            'remittance_saving_method' => 'nullable',
            'plan_after_return' => 'nullable',
            'is_land_purchased' => 'boolean|nullable',
            'land_purchased_location' => 'nullable',
            'have_plan_to_migrate' => 'boolean|nullable',
            'migration_plan_location' => 'nullable',
            'is_other_member_also_on_foreign' => 'boolean|nullable',
        ]);
        if (Auth::user()->is_active) {
            DB::beginTransaction();
            try {
                $munciplaity = Muncipality::where('name', "")->pluck('id')->first();
                HouseRepresentative::create([
                    'name' => $validated['house_representative_name'],
                    'gender' => $validated['house_representative_gender'],
                    'contact_no' => $validated['house_representative_contact_no'],
                    'occupation' => $validated['house_representative_occupation'],
                    'address' => $validated['house_representative_address'],
                    'family_memeber_count' => $validated['family_memeber_count'],
                    'family_members_male_count' => $validated['family_members_male_count'],
                    'family_members_female_count' => $validated['family_members_female_count'],
                    'family_members_other_count' => $validated['family_members_other_count'],
                    'family_migration_count' => $validated['family_migration_count'],
                    'family_members_migration_male_count' => $validated['family_members_migration_male_count'],
                    'family_members_migration_female_count' => $validated['family_members_migration_female_count'],
                    'family_members_migration_other_count' => $validated['family_members_migration_other_count'],
                    'muncipality_id' => $munciplaity,
                    'ward_no' => $validated['ward_no'],
                    'address_1' => $validated['address_1'],
                    'address_2' => $validated['address_2'],
                    'house_no' => $validated['house_no'],
                ]);

                ReturnMigrantWorker::create([
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'age' => $validated['age'],
                    'contact_no' => $validated['contact_no'],
                    'caste' => $validated['caste'],
                    'maritial_status' =>  $validated['maritial_status'],
                    'migrated_country' => $validated['migrated_country'],
                    'migrated_times' => $validated['migrated_times'],
                    'foreign_occupation' => $validated['foreign_occupation'],
                    'home_contact_times' => $validated['home_contact_times'],
                    'is_skilled' => $validated['is_skilled'],
                    'skilled_occupation' => $validated['skilled_occupation'],
                    'have_coomunication_permission' => $validated['have_coomunication_permission'],
                    'communication_permission_method' => $validated['communication_permission_method'],
                    'have_document_in_home' => $validated['have_document_in_home'],
                    'document_type' => $validated['document_type'],
                    'travel_methosd' => $validated['travel_methoed'],
                    'travel_road' => $validated['travel_road'],
                    'travel_fee' => $validated['travel_fee'],
                    'expense_source_abroad' => $validated['expense_source_abroad'],
                    'loan_taken_from' => $validated['loan_taken_from'],
                    'interest_rate_on_loan' => $validated['interest_rate_on_loan'],
                    'is_loan_fully_repaid' => $validated['is_loan_fully_repaid'],
                    'loan_repayment_duration' => $validated['loan_repayment_duration'],
                    'faced_problems_abroad' => $validated['faced_problems_abroad'],
                    'problem_type' => $validated['problem_type'],
                    'have_covid_related_problem' => $validated['have_covid_related_problem'],
                    'covid_problem_type' => $validated['covid_problem_type'],
                    'covid_health_issue' => $validated['covid_health_issue'],
                    'covid_health_issue_type' => $validated['covid_health_issue_type'],
                    'emergency_contact_number' => $validated['emergency_contact_number'],
                    'home_problem' => $validated['home_problem'],
                    'home_problem_type' => $validated['home_problem_type'],
                    'is_remarried' => $validated['is_remarried'],
                    'remarried_gender' => $validated['remarried_gender'],
                    'is_elder_only_home' => $validated['is_elder_only_home'],
                    'is_childer_out_for_study' => $validated['is_childer_out_for_study'],
                    'children_study_location' => $validated['children_study_location'],
                    'total_foreign_income' => $validated['total_foreign_income'],
                    'remittance_method' => $validated['remittance_method'],
                    'is_salary_changed_due_to_covid' => $validated['is_salary_changed_due_to_covid'],
                    'salary_change' => $validated['salary_change'],
                    'remeittance_before_covid' => $validated['remeittance_before_covid'],
                    'previous_year_remeittance_count' => $validated['previous_year_remeittance_count'],
                    'previous_year_remeittance_amount' => $validated['previous_year_remeittance_amount'],
                    'remittance_spend_source' => $validated['remittance_spend_source'],
                    'is_remittance_saved' => $validated['is_remittance_saved'],
                    'remittance_saving_method' => $validated['remittance_saving_method'],
                    'plan_after_return' => $validated['plan_after_return'],
                    'is_land_purchased' => $validated['is_land_purchased'],
                    'land_purchased_location' => $validated['land_purchased_location'],
                    'have_plan_to_migrate' => $validated['have_plan_to_migrate'],
                    'migration_plan_location' => $validated['migration_plan_location'],
                    'is_other_member_also_on_foreign' => $validated['is_other_member_also_on_foreign'],
                ]);

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_representative_name' => 'required',
            'house_representative_gender' => 'required',
            'house_representative_contact_no' => 'required',
            'house_representative_occupation' => 'nullable',
            'house_representative_address' => 'nullable',
            'family_memeber_count' => 'required|numeric',
            'family_members_male_count' => 'required|numeric',
            'family_members_female_count' => 'required|numeric',
            'family_members_other_count' => 'required|numeric',
            'family_migration_count' => 'required|numeric',
            'family_members_migration_male_count' => 'required|numeric',
            'family_members_migration_female_count' => 'required|numeric',
            'family_members_migration_other_count' => 'required|numeric',
            'ward_no' => 'required|numeric',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'house_no' => 'nullable',

            'name' => 'required',
            'gender' => 'required',
            'age' => 'required|numeric',
            'contact_no' => 'required',
            'caste' => 'required',
            'maritial_status' => 'required',
            'total_family_returned' => 'required|numeric',
            'total_family_returned_male' => 'required|numeric',
            'total_family_returned_female' => 'required|numeric',
            'total_family_returned_other' => 'required|numeric',
            'migrated_country' => 'required',
            'home_returned_after' => 'nullable',
            'home_return_reason' => 'nullable',
            'want_to_go_again'  => 'boolean|nullable',
            'occupation_now' => 'nullable',
            'is_employed' => 'boolean|nullable',
            'employed_as' => 'nullable',
            'skill_before_migration' => 'nullable',
            'skilled_occupation' => 'nullable',
            'know_skill_test' => 'boolean|nullable',
            'have_know_skill_test' => 'boolean|nullable',
            'want_to_skill_test' => 'boolean|nullable',
            'foreign_income_used_for' => 'nullable',
            'saved_foriegn_income' => 'nullable',
            'plan_to_business' => 'nullable|boolean',
            'business_plan' => 'nullable',
            'doing_business' => 'nullable',
            'current_business' => 'nullable',
            'emplyees_on_current_business' => 'nullable|numeric',
            'business_help_government' => 'nullable',
            'want_help_type_from_business' => 'nullable',
            'difficulties_to_start_business' => 'nullable',
        ]);
        if (Auth::user()->is_active) {
            DB::beginTransaction();
            try {
                $munciplaity = Muncipality::where('name', "")->pluck('id')->first();
                HouseRepresentative::create([
                    'name' => $validated['house_representative_name'],
                    'gender' => $validated['house_representative_gender'],
                    'contact_no' => $validated['house_representative_contact_no'],
                    'occupation' => $validated['house_representative_occupation'],
                    'address' => $validated['house_representative_address'],
                    'family_memeber_count' => $validated['family_memeber_count'],
                    'family_members_male_count' => $validated['family_members_male_count'],
                    'family_members_female_count' => $validated['family_members_female_count'],
                    'family_members_other_count' => $validated['family_members_other_count'],
                    'family_migration_count' => $validated['family_migration_count'],
                    'family_members_migration_male_count' => $validated['family_members_migration_male_count'],
                    'family_members_migration_female_count' => $validated['family_members_migration_female_count'],
                    'family_members_migration_other_count' => $validated['family_members_migration_other_count'],
                    'muncipality_id' => $munciplaity,
                    'ward_no' => $validated['ward_no'],
                    'address_1' => $validated['address_1'],
                    'address_2' => $validated['address_2'],
                    'house_no' => $validated['house_no'],
                ]);

                CurrentMigrantWorker::create([
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'age' => $validated['age'],
                    'contact_no' => $validated['contact_no'],
                    'caste' => $validated['caste'],
                    'maritial_status' => $validated['maritial_status'],
                    'total_family_returned' => $validated['total_family_returned'],
                    'total_family_returned_male' => $validated['total_family_returned_male'],
                    'total_family_returned_female' => $validated['total_family_returned_female'],
                    'total_family_returned_other' => $validated['total_family_returned_other'],
                    'migrated_country' => $validated['migrated_country'],
                    'home_returned_after' => $validated['home_returned_after'],
                    'home_return_reason' => $validated['home_return_reason'],
                    'want_to_go_again'  => $validated['want_to_go_again'],
                    'occupation_now' => $validated['occupation_now'],
                    'is_employed' => $validated['is_employed'],
                    'employed_as' => $validated['employed_as'],
                    'skill_before_migration' => $validated['skill_before_migration'],
                    'skilled_occupation' => $validated['skilled_occupation'],
                    'know_skill_test' => $validated['know_skill_test'],
                    'have_know_skill_test' => $validated['have_know_skill_test'],
                    'want_to_skill_test' => $validated['want_to_skill_test'],
                    'foreign_income_used_for' => $validated['foreign_income_used_for'],
                    'saved_foriegn_income' => $validated['saved_foriegn_income'],
                    'plan_to_business' => $validated['plan_to_business'],
                    'business_plan' => $validated['business_plan'],
                    'doing_business' => $validated['doing_business'],
                    'current_business' => $validated['current_business'],
                    'emplyees_on_current_business' => $validated['emplyees_on_current_business'],
                    'business_help_government' => $validated['business_help_government'],
                    'want_help_type_from_business' => $validated['want_help_type_from_business'],
                    'difficulties_to_start_business' => $validated['difficulties_to_start_business'],
                ]);

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
