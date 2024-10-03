<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SlotsExport implements FromCollection,WithHeadings, WithStyles,  WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $as_id;
    protected $at_id;


    public function __construct($as_id,$at_id)
    {
        $this->as_id = $as_id;
        $this->at_id = $at_id;
    }

    public function collection()
    {
        $at_id=$this->at_id;
        $as_id=$this->as_id;
        if($at_id!=null) {
            $data = DB::table('slots as S')
                ->select('S.slot_time')
                ->selectSub(function ($query) use ($at_id) {
                    $query->select(DB::raw("GROUP_CONCAT(u.am, ' - ', u.name SEPARATOR ', ')"))
                        ->from('users AS u')
                        ->join('teams AS T1', 'u.am', '=', 'T1.am')
                        ->whereColumn('T1.t_id', '=', 'S.am')
                        ->where('T1.at_id', '=', $at_id);
                }, 'part')
                ->where('S.as_id', '=', $as_id)
                ->orderBy('S.slot_time', 'asc')
                ->get();
        }
        else{
            $data = DB::table('slots as S')
                ->select('S.slot_time')
                ->selectSub(function ($query) {
                    $query->select(DB::raw("CONCAT(U.am, '-', U.name)"))
                        ->from('users AS U')
                        ->whereColumn('U.am', '=', 'S.am');
                }, 'part')
                ->where('S.as_id', '=', $as_id)
                ->orderBy('S.slot_time', 'asc')
                ->get();


        }


        return $data;
    }
    public function headings(): array
    {
        return [
            'Ημερομηνία',
            'Φοιτητές',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 35, // Set the width for column A
            'B' => 100, // Set the width for column B
        ];
    }

}
