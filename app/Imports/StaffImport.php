<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $check = Staff::where('staffNo', $row['staffno'])->exists(); 
        if(!$check)
        {
            $data = new Staff();
            $data->sname = $row['staff_name'];
            $data->email = $row['staff_email'];
            $data->staffNo = $row['staffno'];
            $data->password = $row['password'];
            $data->sphoneNo = $row['staff_phoneno'];
            $data->sdepartment = $row['staff_department'];
            $data->srole = $row['staff_role'];
            $data->save();

        }
    }
}
