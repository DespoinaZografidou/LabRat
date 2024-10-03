<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChooseThemesExport implements FromCollection,WithHeadings, WithStyles, WithColumnWidths
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
            $data = DB::table('themes AS Th')
                ->leftJoin('themes_choises AS TC', 'Th.id', '=', 'TC.th_id')
                ->leftJoin('teams AS T', function ($join) use ($at_id) {
                    $join->on('T.t_id', '=', 'TC.am')
                        ->where('T.at_id', '=', $at_id);
                })
                ->leftJoin('users AS U', 'U.am', '=', 'T.am')
                ->Select('Th.title', DB::raw("GROUP_CONCAT(U.am,' - ',U.name)"))
                ->where('Th.ct_id', '=', $act_id)
                ->groupBy('T.t_id', 'Th.title')
                ->orderBy('Th.title')
                ->get();

        }
        else{

            $data = DB::table('themes')
                ->Select('themes.title', DB::raw('CONCAT(users.am, " - ", users.name)'))
                ->leftJoin('themes_choises', 'themes.id', '=', 'themes_choises.th_id')
                ->leftJoin('users', 'users.am', '=', 'themes_choises.am')
                ->where('themes.ct_id', '=', $act_id)
                ->orderBy('themes.title')
                ->get();
        }


        return $data;
    }
    public function headings(): array
    {
        return [
            'Τίτλος Θέματος',
            'Φοιτητές/Ομάδες',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 80, // Set the width for column A
            'B' => 100, // Set the width for column B
        ];
    }

}
