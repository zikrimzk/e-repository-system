<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\HorizontalBar;

class StudentChart
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
                    ->select('b.id as progid','b.prog_code','b.prog_mode','a.matricNo')
                    ->get();

        $var[] ='';
        foreach($data1->unique('progid') as $d)
        {
            $var[]=$d->prog_code .' ('. $d->prog_mode.') ';
        
        }
        $varC[]=0;
        foreach($data1->groupBy('progid') as $d)
        {
            $varC[]=$d->count();
        
        }
        return $this->chart->horizontalBarChart()
            ->addData('Programme',$varC)
            ->setColors(['#FFC107', '#D32F2F'])
            ->setHeight(300)
            ->setXAxis($var);
    }
}
