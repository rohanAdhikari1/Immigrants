<?php

namespace App\Filament\Pages;

use App\Models\CurrentMigrantWorker;
use App\Models\ReturnedMigrantWorker;
use Filament\Actions\Action;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('check')
                ->label('Export Report')
                ->icon('heroicon-o-arrow-up-on-square')
                ->action('export')
                ->visible(fn() => auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
        ];
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('वैदेशिक रोजगारमा गएका ...');
        $this->populateCurrentMigrant($sheet1);

        $sheet2 = new Worksheet($spreadsheet, 'वैदेशिक रोजगारबाट फर्केर ...');
        $spreadsheet->addSheet($sheet2);
        $this->populateReturnedMigrant($sheet2);


        $writer = new Xlsx($spreadsheet);
        $fileName = 'report.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function populateCurrentMigrant(Worksheet $sheet)
    {
        $headers = [
            'गाउँ/नगरपालिका',
            'वडा नं.',
            'टोलको नाम',
            'टोलको कोड नं.',
            'घर नं.',
            'भ्रमण मिति',
            'घरमुलीको नाम थर',
            'घरमुलीको लैङ्गिक अवस्था',
            'मोबाइल नं.',
            'सूचनादाताको नाम ',
            'घरमुलीसँगको नाता',
            'मातृभाषा',
            'धर्म',
            'परिवारको सदस्य संख्या पुरुष',
            'परिवारको सदस्य संख्या महिला',
            'घरको मुख्य पेशा',
            'व्यक्त्तिको नाम',
            'उमेर',
            'लिङ्ग',
            'घरमुलीसँगको नाता',
            'शैक्षिक बिवरण',
            'वैवाहिक अवस्था',
            'हाल गएको देश',
            'वैदेशिक रोजगारमा गएको पटक',
            'माध्यमबाट जानु भएको',
            'वाटो',
            'भिषा',
            'विदेशजाने क्रममा तयार गरिएका कागजपत्रहरु घररमा छाडेका',
            'वैदेशिक रोजगारमा जानु पूर्व सीप तालिम ',
        ];
        $sheet->fromArray($headers, null, 'A1');
        $headerRange = 'A1:' . $sheet->getHighestColumn() . '1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);
        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $row = 2;
        $data = CurrentMigrantWorker::with('household', 'municipality')->get();
        foreach ($data as $item) {
            $sheet->fromArray([
                $item->municipality?->name,
                $item->household?->ward_no,
                $item->household?->toll_name,
                $item->household?->toll_no,
                $item->household?->house_no,
                $item->household?->visit_date,
                $item->household?->house_representative_name,
                $item->household?->house_represent_gender,
                $item->household?->house_represent_contact_no,
                $item->informationProvider?->name,
                $item->informationProvider?->relation_to_hr,
                $item->informationProvider?->mother_tongue,
                $item->informationProvider?->religion,
                $item->household?->family_members_male_count,
                $item->household?->family_members_female_count,
                $item->household?->house_represent_occupation,
                $item->name,
                $item->age,
                $item->gender,
                $item->relation_to_hr,
                $item->education_detail,
                $item->maritial_status,
                $item->foreign_country,
                $item->number_of_times_fe,
                $item->mode_of_travel,
                $item->route_taken,
                $item->visa_type,
                $item->documents_left_on_home,
                $item->skill_training_before_foreign_employment,
                $item->received_information_or_counseling_before_foreign_employment,
                $item->amount_paid_for_foreign_employment,
                $item->major_source_of_amount_paid,
                $item->current_job_abroad,
                $item->problems_faced_during_foreign_employment,
                $item->problems_faced_during_foreign_employment_type,
                $item->family_problems_during_foreign_employment,
                $item->family_problems_during_foreign_employment_type,
                $item->second_marriage_done_by,
                $item->only_elder_at_home_due_to_foreign_employment,
                $item->children_sent_to_boarding_school_in_headquarters_or_other_city,
                $item->is_amount_sent_at_home_last_1_year,
                $item->reason_for_not_sending_money,
                $item->times_money_sent_home_last_1_year,
                $item->amount_sent_home_last_1_year,
                $item->remittance_expenditure_last_1_year,
                $item->place_of_purchase_of_house_or_land_from_remittance,
                $item->place_of_saving_remittance,
                $item->place_of_receiving_money_from_abroad,
                $item->migration_plan_location,
                $item->plan_after_return,
            ], null, "A{$row}");
            $row++;
        }
    }

    public function populateReturnedMigrant(Worksheet $sheet)
    {
        $headers = [
            'गाउँ/नगरपालिका',
            'वडा नं.',
            'टोलको नाम',
            'टोलको कोड नं.',
            'घर नं.',
            'भ्रमण मिति',
            'घरमुलीको नाम थर',
            'घरमुलीको लैङ्गिक अवस्था',
            'मोबाइल नं.',
            'सूचनादाताको नाम ',
            'घरमुलीसँगको नाता',
            'मातृभाषा',
            'धर्म',
            'परिवारको सदस्य संख्या पुरुष',
            'परिवारको सदस्य संख्या महिला',
            'घरको मुख्य पेशा',
            'व्यक्त्तिको नाम',
            'उमेर',
            'लिङ्ग',
            '',
            'घरमुलीसँगको नाता',
            'शैक्षिक बिवरण',
            'वैवाहिक अवस्था',
        ];
        $sheet->fromArray($headers, null, 'A1');
        $headerRange = 'A1:' . $sheet->getHighestColumn() . '1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
        ]);
        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $row = 2;
        $data = ReturnedMigrantWorker::with('household', 'municipality')->get();
        foreach ($data as $item) {
            $sheet->fromArray([
                $item->municipality?->name,
                $item->household?->ward_no,
                $item->household?->toll_name,
                $item->household?->toll_no,
                $item->household?->house_no,
                $item->household?->visit_date,
                $item->household?->house_representative_name,
                $item->household?->house_represent_gender,
                $item->household?->house_represent_contact_no,
                $item->informationProvider?->name,
                $item->informationProvider?->relation_to_hr,
                $item->informationProvider?->mother_tongue,
                $item->informationProvider?->religion,
                $item->household?->family_members_male_count,
                $item->household?->family_members_female_count,
                $item->household?->house_represent_occupation,
                $item->name,
                $item->age,
                $item->gender,
                $item->contact_no,
                $item->relation_to_hr,
                $item->education_detail,
                $item->maritial_status,
                $item->foreign_country,
                $item->years_since_returned,
                $item->reason_for_returning_from_foreign_employment,
                $item->disability_or_incapacity_due_to_foreign_employment,
                $item->type_of_work_done_abroad,
                $item->work_experience_during_foreign_employment,
                $item->skill_training_after_return_to_nepal,
                $item->current_occupation,
                $item->type_of_own_business,
                $item->challenges_in_starting_new_business,
                $item->intention_to_return_to_foreign_employment,
                $item->desired_or_current_work_area_in_nepal,
                $item->requirements_for_employment_in_nepal,
                $item->post_foreign_employment_family_issues,
                $item->post_foreign_employment_family_issues_type,
                $item->post_foreign_employment_family_issues_type_other,
                $item->post_foreign_employment_health_issues,
                $item->post_foreign_employment_health_issues_type,
                $item->post_foreign_employment_health_issues_type_other,
                $item->post_foreign_employment_social_or_family_accusations,
                $item->post_foreign_employment_social_or_family_accusations_type,
            ], null, "A{$row}");
            $row++;
        }
    }
}
