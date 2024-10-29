<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MySvStudentExport implements FromCollection,WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       
        $svstudent = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('semesters as c','a.semester_id','=','c.id')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','Active')
                        ->select('a.name','a.matricNo','a.phoneNo','a.email','a.titleOfResearch as title',
                                'b.prog_code as code','b.prog_mode as mode','c.label as sem','d.supervision_role as svrole')
                        ->get(); 
        return $svstudent ;
    }

    public function headings(): array
    {
        return ["Name", "Matric No", "Phone No.", "Email", "Title Of Research ","Programme","Mode","Semester","Lecturer Role"];
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(60);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);



            },
        ];
    }
}
