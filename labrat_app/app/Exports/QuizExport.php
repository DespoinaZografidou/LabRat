<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuizExport implements FromCollection,WithHeadings, WithStyles,  WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $act_id;


    public function __construct($act_id)
    {
        $this->act_id = $act_id;


    }
    public function collection()
    {
        $maxnum = DB::table('quiz_questions')
            ->where('aq_id', $this->act_id)
            ->sum('maxgrade');
        $data=DB::table('quiz_tries AS QT')->select('am as am','id as try','finalscore as finalscore','delivered as delivered')
            ->where('QT.aq_id','=', $this->act_id)
            ->orderBy('am')
            ->orderBy('id')
            ->get();


        $counter = 1; // Initialize the counter
        $temp='';

        foreach ($data as $index => $d) {
            if ($index === 0) {
                $temp=$d->am;
                $d->try = $counter . 'η Προσπάθεια';
                $d->finalscore=$d->finalscore.'/'.$maxnum;
                if($d->delivered===0){
                    $d->delivered='Αποθηκευμένο';
                }else{
                    $d->delivered='Υποθλήθηκε';
                }
            } else {
                if ($d->am === $temp) {
                    $counter++;
                    $d->am='';
                    $d->try =$counter . 'η Προσπάθεια';
                    $d->finalscore=$d->finalscore.'/'.$maxnum;
                    if($d->delivered===0){
                        $d->delivered='Αποθηκευμένο';
                    }else{
                        $d->delivered='Υποθλήθηκε';
                    }

                } else {
                    $counter=1;
                    $temp = $d->am;
                    $d->try = $counter . 'η Προσπάθεια';
                    $d->finalscore=$d->finalscore.'/'.$maxnum;
                    if($d->delivered===0){
                        $d->delivered='Αποθηκευμένο';
                    }else{
                        $d->delivered='Υποθλήθηκε';
                    }
                }
            }
        }

        return $data;
    }
    public function headings(): array
    {
        return [

            'Αρ.Μητρώου',
            'Αρ.Προσπάθειας',
            'Βαθμολογία',
            '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:A500')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '9BD64F', // Specify the background color, e.g., 'FFFF00' for yellow
                ],
            ],
        ]);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Set the width for column A
            'B' => 15, // Set the width for column B
            'C' => 20, // Set the width for column C
            'D' => 15,
            // Add more columns and their widths as needed
        ];
    }
}
