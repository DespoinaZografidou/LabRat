<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipationExport implements FromCollection,WithHeadings, WithStyles,  WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $l_id;

    public function __construct($l_id)
    {
        $this->l_id = $l_id;

    }
    public function collection()
    {
        return DB::table('Participations AS P')->
        where('P.l_id','=',$this->l_id)->
        join('users','users.am','=','P.am')->
        Select('users.am','users.name','users.email')->orderby('P.am','asc')->get();
    }
    public function headings(): array
    {
        return [
            'Αρ.Μητρώου',
            'Ονοματεπώνυμο',
            'Ηλ.Διεύθυνση',
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
            'B' => 38, // Set the width for column B
            'C' => 30, // Set the width for column C
            // Add more columns and their widths as needed
        ];
    }
}
