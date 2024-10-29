<?php

namespace App\Charts;

use App\Models\Staff;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class StaffChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {

        $TotalComm      = Staff::where('srole','Committee')->count();
        $TotalLec       = Staff::where('srole','Lecturer')->count();
        $Totaltdp       = Staff::where('srole','Timbalan Dekan Pendidikan')->count();

        return $this->chart->pieChart()
            ->addData([$TotalComm, $TotalLec , $Totaltdp ])
            ->setLabels(['Committees','Lecturers','Timbalan Dekan']);
    }
}
