<?php

namespace App\Laravel\Models\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{FromCollection, Exportable, WithMapping, WithHeadings, ShouldAutoSize, WithColumnWidths, WithColumnFormatting, WithStyles, WithEvents};
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Maatwebsite\Excel\Events\AfterSheet;

use Helper, Str, Carbon;


class  SalesReport implements WithEvents, FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(Collection $transactions, $grand_total)
    {
        $this->transactions = $transactions;
        $this->grand_total = $grand_total;
    }

    public function headings(): array
    {
        return [
            [
                'REPORT'
            ],
            [
                'DATE GENERATED : ' . now()->format('F d, Y')
            ],
            [
                'Transaction Number',
                'Date',
                'Billed',
                'Gender',
                'Contact Number',
                'Birthdate',
                'Bill Amount',
                '12% Vat',
                '20% Discount',
                'Total Bill Amount',
            ]
        ];
    }

    public function map($value): array
    {

        return [
            $value->code,
            $value->created_at ? $value->created_at->format('F d, Y') : '',
            $value->billed ? $value->billed->name : '---',
            $value->billed ? $value->billed->gender : '---',
            $value->billed ? $value->billed->phone_number : '---',
            $value->billed ? Helper::date_only($value->billed->birthdate) : '---',
            Helper::money_format($value->amount),
            Helper::money_format($value->vat),
            Helper::money_format($value->discount),
            $value->total ? Helper::money_format($value->total) : '---',

        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'G' => NumberFormat::FORMAT_NUMBER,
            'E' => '+#',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 40,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 30,
            'I' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $last_row_to_protect = $this->transactions->count() + 3;
        // PROTECT worksheet sheet
        $sheet->getProtection()->setPassword('daily-report');
        $sheet->protectCells("A3:A{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("B3:B{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("C3:C{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("D3:D{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("E3:E{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("F3:F{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("G3:G{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("H3:H{$last_row_to_protect}", 'daily-report');
        $sheet->protectCells("I3:I{$last_row_to_protect}", 'daily-report');
        $sheet->getProtection()->setSheet(true);
        return [
            1    => ['font' => ['bold' => true, 'size' => 24]],
            2    => ['font' => ['bold' => true]],
            3    => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->setCellValue('F' . ($event->sheet->getHighestRow() + 1), "GRAND TOTAL");
                $event->sheet->setCellValue('G' . ($event->sheet->getHighestRow()), $this->grand_total);
                $event->sheet->getDelegate()->getStyle('A' . $event->sheet->getHighestRow() . ':' . $event->sheet->getDelegate()->getHighestColumn() . $event->sheet->getHighestRow())
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');


                $event->sheet->getStyle('E:E')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );

                $event->sheet->getStyle('F:F')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );

                $event->sheet->getStyle('G:G')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );

                $event->sheet->getStyle('H:H')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );

                $event->sheet->getStyle('I:I')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );

                $event->sheet->getStyle('J:J')->getAlignment()->applyFromArray(
                    array('horizontal' => 'left')
                );
            }
        ];
    }
}
