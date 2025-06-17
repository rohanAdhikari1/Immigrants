<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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
        ];
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('First Model Data');

        $sheet2 = new Worksheet($spreadsheet, 'Second Model Data');
        $spreadsheet->addSheet($sheet2);


        $writer = new Xlsx($spreadsheet);
        $fileName = 'report.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($tempFile);
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
