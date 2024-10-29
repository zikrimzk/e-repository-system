<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplate implements WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return ["student_name", "student_email", "matricno", "password", "student_phoneno", "student_gender","programme_code","programme_mode","sv_id","cosv_id","title_research"];
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
   
                $event->sheet->setTitle('student_template');
                $event->sheet->setCellValue('D2', 'abcd1234');
                $event->sheet->setCellValue('F2', 'M OR F');
                $event->sheet->setCellValue('H2', 'PT(Part time) OR FT(Full time)');
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
             

     
            },
        ];
    }
}
