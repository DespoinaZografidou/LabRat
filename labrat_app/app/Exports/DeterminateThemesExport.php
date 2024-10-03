<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class DeterminateThemesExport implements FromCollection,WithHeadings, WithStyles, WithColumnWidths
{
    protected $act_id;
    protected $at_id;


    public function __construct($act_id,$at_id)
    {
        $this->act_id = $act_id;
        $this->at_id = $at_id;
    }

    public function collection()
    {
        $at_id=$this->at_id;
        $act_id=$this->act_id;
        if($at_id!=null) {
            $data = DB::table('journals AS J')
                ->leftJoin('determinate_themes AS D', 'J.id', '=', 'D.j_id')
                ->leftJoin('teams AS T', function ($join) use ($at_id) {
                    $join->on('T.t_id', '=', 'D.am')
                        ->where('T.at_id', '=', $at_id);
                })
                ->leftJoin('users AS U', 'U.am', '=', 'T.am')
                ->select('J.title as journal_title','D.title  as theme_title', DB::raw("GROUP_CONCAT(U.am,'-',U.name) AS part"))
                ->where('J.adt_id', '=', $act_id)
                ->where('D.confirm','=',1)
                ->where('D.am', '!=', ' ')
                ->groupBy('T.t_id', 'J.id', 'J.adt_id', 'J.title', 'J.text','J.link','D.title','D.id','D.confirm')
                ->orderBy('J.title')
                ->orderBy('D.title')
                ->get();

        }
        else{

            $data = DB::table('journals as J')
                ->select('J.title as journal_title', 'D.title  as theme_title', DB::raw('CONCAT(users.am, " - ", users.name) AS part'))
                ->leftJoin('determinate_themes AS D', 'J.id', '=', 'D.j_id')
                ->leftJoin('users', 'users.am', '=', 'D.am')
                ->where('J.adt_id', '=', $act_id)
                ->where('D.confirm','=',1)
                ->where('D.am', '!=', ' ')
                ->orderBy('J.title')
                ->orderBy('D.title')
                ->get();

        }


        return $data;
    }
    public function headings(): array
    {
        return [
            'Θέμα/Περιοδικό',
            'Θέμα/Άρθρο',
            'Συμμετοχή'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 80, // Set the width for column A
            'B' => 80, // Set the width for column B
            'C'=> 100,
        ];
    }
}
