<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\BarChart;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\HorizontalBar;

class StuSvSubChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): BarChart
    {

        $sub = DB::table('students as a')
                    ->join('programmes as b','a.programme_id','=','b.id')
                    ->join('student_staff as d','a.id','=','d.student_id')
                    ->join('staff as e','d.staff_id','=','e.id')
                    ->join('submissions as f','a.id','=','f.student_id')
                    ->join('documents as g','f.document_id','=','g.id')
                    ->join('activities as h','g.activity_id','=','h.id')
                    ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                    ->where('d.staff_id','=',auth()->user()->id)
                    ->where('a.status','Active')
                    ->whereIn('f.submission_status',['Submitted'])
                    ->orderBy( 'actid','asc')
                    ->select(
                            'a.matricNo',
                            'h.id as actid',
                            'g.id as docid',
                            'g.doc_name as docname',
                            'h.act_name as actname',
                            'f.submission_status'

                            )
                    ->get();
        if($sub->count()>=1)
        {
            foreach($sub->unique('docid') as $d)
            {
                $act[] = $d->docname;
            
            }
            foreach($sub->groupby('docid') as $d)
            {
                $acts[] =$d->count();
            }
        
            // dd($act,$acts);
            
        }
        else
        {
            $act[] = '';
            $acts[] =0;
        }  
        
        return  $this->chart->BarChart()
            ->addData('Submitted', $acts)
            ->setColors(['#FFC107', '#D32F2F'])
            ->setXAxis($act);

        
       
        
    }
}
