<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MappedGroupedClassesWeekSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $title;

    public function __construct($data, $title)
    {
        $this->data = collect($data);
        $this->title = $title;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Hiring Summary'; // Specify the title of the worksheet
    }

    public function headings(): array
    {
        // Define your headings for MappedB2Classes sheet
        return [
            'Site',
            'Program',
            'Dec 31 - Jan 6',
            'Jan 7 - Jan 13',
            'Jan 14 - Jan 20',
            'Jan 21 - Jan 27',
            'January',
            'Jan 28 - Feb 3',
            'Feb 4 - Feb 10',
            'Feb 11 - Feb 17',
            'Feb 18 - Feb 24',
            'February',
            'Feb 25 - Mar 2',
            'Mar 3 - Mar 9',
            'Mar 10 - Mar 16',
            'Mar 17 - Mar 23',
            'Mar 24 - Mar 30',
            'March',
            'Mar 31 - Apr 6',
            'Apr 7 - Apr 13',
            'Apr 14 - Apr 20',
            'Apr 21 - Apr 27',
            'April',
            'Apr 28 - May 4',
            'May 5 - May 11',
            'May 12 - May 18',
            'May 19 - May 25',
            'May',
            'May 26 - Jun 1',
            'Jun 2 - Jun 8',
            'Jun 9 - Jun 15',
            'Jun 16 - Jun 22',
            'Jun 23 - Jul 29',
            'June',
            'Jun 30 - Jul 6',
            'Jul 7 - Jul 13',
            'Jul 14 - Jul 20',
            'Jul 21 - Jul 27',
            'July',
            'Jul 28 - Aug 3',
            'Aug 4 - Aug 10',
            'Aug 11 - Aug 17',
            'Aug 18 - Aug 24',
            'Aug 25 - Aug 31',
            'August',
            'Sep 1 - Sep 7',
            'Sep 8 - Sep 14',
            'Sep 15 - Sep 21',
            'Sep 22 - Sep 28',
            'September',
            'Sep 29 - Oct 5',
            'Oct 6 - Oct 12',
            'Oct 13 - Oct 19',
            'Oct 20 - Oct 26',
            'October',
            'Oct 27 - Nov 2',
            'Nov 3 - Nov 9',
            'Nov 10 - Nov 16',
            'Nov 17 - Nov 23',
            'Nov 24 - Nov 30',
            'November',
            'Dec 1 - Dec 7',
            'Dec 8 - Dec 14',
            'Dec 15 - Dec 21',
            'Dec 22 - Dec 28',
            'December',
            'Total',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:BO1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                foreach (range('A', 'BO') as $column) {
                    $cell = $sheet->getCell($column.'1');
                    $cell->setValue(strtoupper($cell->getValue()));
                }
                $lastRowBO = $sheet->getHighestRow('BO');
                $sheet->getStyle('BO2:BO'.$lastRowBO)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '0000FF'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $columns = ['G', 'L', 'R', 'W', 'AB', 'AH', 'AM', 'AS', 'AX', 'BC', 'BI', 'BN'];
                foreach ($columns as $column) {
                    $sheet->getStyle($column.'2:'.$column.$lastRowBO)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => ['argb' => 'FFFFFF'],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => '0000FF'],
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                }

                for ($row = 2; $row <= $sheet->getHighestRow(); ++$row) {
                    if (empty($sheet->getCell('B'.$row)->getValue())) {
                        $sheet->getStyle('C'.$row.':BO'.$row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => 'FFFFFF'],
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => '0000FF'],
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
