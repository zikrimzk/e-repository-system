<?php

namespace App\Charts;

use App\Models\Student;
use App\Models\Programme;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\PieChart;
use ArielMejiaDev\LarapexCharts\DonutChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StudentProgrammeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        $TS  = Student::all()->count();
        $TSA  = Student::where('status','Active')->count();
        $TSI   = Student::where('status','Inactive')->count();
    
        return $this->chart->pieChart()
            ->addData([$TSA, $TSI])
            ->setColors(['#303F9F','#FFC107'])
            ->setLabels(['Active Student', 'Inactive Student']);
    }
}
