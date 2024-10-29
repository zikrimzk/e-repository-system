<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StaffTemplate implements WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return ["staffno", "staff_name", "staff_email", "staff_phoneNo", "staff_department","staff_role","password"];
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
   
                $event->sheet->setTitle('staff_template');
                // $event->sheet->setCellValue('D2', 'abcd1234');
                // $event->sheet->setCellValue('F2', 'M OR F');
                // $event->sheet->setCellValue('H2', 'PT(Part time) OR FT(Full time)');
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);

        
            },
        ];
    }
}
