<?php

namespace App\Exports;

use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentStaff;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentStaffExport implements FromCollection,WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $stusta = DB::table('student_staff as a')
                    ->join('students as b','a.student_id', '=' , 'b.id')
                    ->join('staff as c','a.staff_id', '=' , 'c.id')
                    ->join('programmes as d','b.programme_id', '=' , 'd.id')
                    ->select('b.name', 'b.matricNo','d.prog_code','c.sname','a.supervision_role')
                    ->get();
        return $stusta;

        
    }

    public function headings(): array
    {
        return ["Student Name", "Matric No", "Code", "Staff Name", "Role"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
   
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
            
            },
        ];
    }
}
