<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\HorizontalBar;

class StudentSvChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): HorizontalBar
    {
        $data1 = DB::table('students as a')
        ->join('programmes as b','a.programme_id','b.id')
        ->join('student_staff as c','a.id','c.student_id')
        ->whereIn('c.supervision_role',['Supervisor','Co-Supervisor'])
        ->where('c.staff_id',auth()->user()->id)
        ->select('b.id as progid','b.prog_code','b.prog_mode','a.matricNo')
        ->get();

        if($data1->count() >=1)
        {
            foreach($data1->unique('progid') as $d)
            {
                $var[]=$d->prog_code .' ('. $d->prog_mode.') ';
            }
            foreach($data1->groupBy('progid') as $d)
            {
                $varC[]=$d->count();
            }
        }
        else
        {
            $var[]= '';
            $varC[]= 0;
        }
        
        return $this->chart->horizontalBarChart()
        ->addData('Programme',$varC)
        ->setColors(['#303F9F', '#D32F2F'])
        ->setHeight(300)
        ->setXAxis($var);
    }
}
