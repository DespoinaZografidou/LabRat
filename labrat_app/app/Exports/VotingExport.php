<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VotingExport implements FromCollection,WithHeadings, WithStyles, WithColumnWidths
{
    protected $act_id;

    public function __construct($act_id)
    {
        $this->act_id = $act_id;

    }

    public function collection()
    {

        $act_id=$this->act_id;
        $data = DB::table('questions as Q')
            ->select('Q.text as question', 'Q.type','A.text as answer')
            ->selectRaw('(SELECT COUNT(V.a_id) FROM voting AS V WHERE V.a_id = A.id GROUP BY V.a_id) /(SELECT COUNT(V.q_id) FROM voting AS V WHERE V.q_id = Q.id GROUP BY V.q_id) * 100 AS votes_percentage')
            ->selectRaw('(SELECT COUNT(DISTINCT V.am) FROM voting AS V WHERE V.q_id = Q.id) AS voters')
            ->selectRaw('(SELECT COUNT(DISTINCT V.am) FROM voting AS V WHERE V.a_id = A.id) AS numvoters')
            ->leftJoin('answers as A', 'A.q_id', '=', 'Q.id')
            ->where('Q.av_id', '=', $act_id)
            ->orderBy('Q.id')
            ->orderBy('A.id')
            ->get();

        foreach ($data as $d){
            $d->question=str_replace(['<p>','</p>','<strong>','</strong>','<span style="text-decoration: underline;">','</span>'],['','','','','',''],$d->question);
            $d->answer=str_replace(['<p>','</p>','<strong>','</strong>','<span style="text-decoration: underline;">','</span>'],['','','','','',''],$d->answer);
            if($d->votes_percentage>0){
                $d->votes_percentage=$d->votes_percentage.'%';
            }

        }


        $temp='';
        foreach ($data as $index => $d) {
            if ($index === 0) {
                $temp=$d->question;
                $d->voters=$d->numvoters.'/'.$d->voters;
                $d->numvoters='';

            } else {
                if ($d->question === $temp) {
                    $d->type='';
                    $d->question='';
                    $d->voters=$d->numvoters.'/'.$d->voters;
                    $d->numvoters='';
                } else {

                    $temp=$d->question;
                    $d->voters=$d->numvoters.'/'.$d->voters;
                    $d->numvoters='';
                }
            }

        }

        return $data;
    }
    public function headings(): array
    {
        return [
            'Ερώτηση',
            'Τύπος Ερώτησης',
            'Απάντηση',
            'ψήφοι',
            'Αρ.Ψηφοφόρων'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

//        $sheet->getStyle('A')->getFont()->setBold(true);
        // Set the height for specific rows based on content in the title column
        foreach ($sheet->getRowDimensions() as $rowIndex => $rowDimension) {
            $cellValue = $sheet->getCell('A' . $rowIndex)->getValue();

            // Adjust the condition based on your specific criteria
            if ($cellValue !== ' ' && $rowIndex > 1) {
                $rowDimension->setRowHeight(25); // Set the desired height
            }
        }
    }
    public function columnWidths(): array
    {
        return [
            'A' =>80, // Set the width for column A
            'B' => 19, // Set the width for column B
            'C' => 60, // Set the width for column A
            'D' => 13, // Set the width for column B
            'E' => 15, // Set the width for column A
        ];
    }



}
