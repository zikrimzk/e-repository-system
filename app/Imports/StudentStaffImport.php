<?php

namespace App\Imports;

use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentStaff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentStaffImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $data = new StudentStaff();
        $data->student_id = Student::where('matricNo',$row['matricno'])->first()->id;;
        $data->staff_id = Staff::where('staffNo',$row['staffno'])->first()->id;;
        $data->role = $row['role'];
        $data->save();
    }
}
