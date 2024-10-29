<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements FromCollection,WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $student = DB::table('students')
                    ->join('semesters','students.semester_id', '=' , 'semesters.id')
                    ->join('programmes','students.programme_id', '=' , 'programmes.id')
                    ->where('students.status', '=', 'Active')
                    ->select('students.matricNo', 'students.name','students.email','students.phoneNo','students.gender','students.status','semesters.label','programmes.prog_code','programmes.prog_mode')
                    ->get();
                 

                    // $student = DB::table('students')
                    // ->join('semesters','students.semester_id', '=' , 'semesters.id')
                    // ->where('semesters.status', '=', 'Active')
                    // ->join('programmes','students.programme_id', '=' , 'programmes.id')
                    // ->join('student_staff as ss','students.id', '=' , 'ss.student_id')
                    // ->join('staff as st','ss.staff_id', '=' , 'st.id')
                    // ->select('students.matricNo', 'students.name','students.email','students.phoneNo','students.gender','students.status','semesters.label','programmes.prog_code','programmes.prog_mode')
                    // ->get();            
        return $student;
    }

    public function headings(): array
    {
        return ["Matric No", "Full Name", "Email", "Phone Number", "Gender","Status", "Semester","Programme","Mode"];
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
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);

             

     
            },
        ];
    }
}
