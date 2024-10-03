<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeamsExport implements FromCollection,WithHeadings, WithStyles,  WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $at_id;


    public function __construct($at_id)
    {
        $this->at_id = $at_id;


    }
    public function collection()
    {
        $data=  DB::table('teams as T')
            ->where('T.at_id', '=', $this->at_id)
            ->where('T.confirm', '=', 1)
            ->select('T.t_id as no_team','U.am', 'U.name', DB::raw("IF(T.am = T.t_id, 'Διαχειριστής', NULL) as role"))
            ->join('users as U', 'U.am', '=', 'T.am')
            ->orderBy('T.t_id')
            ->get();


        $counter = 1; // Initialize the counter
        $temp='';

        foreach ($data as $index => $d) {
            if ($index === 0) {
                $temp=$d->no_team;
                $d->no_team = $counter . 'η Ομάδα';
            } else {
                if ($d->no_team === $temp) {
                    $d->no_team =' ';
                } else {
                    $counter++;
                    $temp=$d->no_team;
                    $d->no_team = $counter . 'η Ομάδα';
                }
            }
        }

        return $data;
    }
    public function headings(): array
    {
        return [
            ' ',
            'Αρ.Μητρώου',
            'Ονοματεπώνυμο',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Set the width for column A
            'B' => 15, // Set the width for column B
            'C' => 38, // Set the width for column C
            'D' => 15,
            // Add more columns and their widths as needed
        ];
    }
}
