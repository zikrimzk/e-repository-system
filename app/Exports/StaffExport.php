<?php

namespace App\Exports;

use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StaffExport implements FromCollection,WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       
        $staff = DB::table('staff as a')
                    ->join('departments as b','a.dep_id','=','b.id')
                    ->select('a.staffNo','a.sname','a.email','a.sphoneNo','b.dep_name','a.srole')
                    ->get();    
        return $staff;
    }

    public function headings(): array
    {
        return ["Staff No", "Name", "Email", "Phone Number", "Department","Role"];
    }
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
            },
        ];
    }
}
