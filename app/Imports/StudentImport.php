<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Programme;
use App\Models\Submission;
use App\Models\StudentStaff;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $check = Student::where('matricNo', $row['matricno'])->exists();
        if(!$check)
        {
            $sem = Semester::where('status', 'Active')->first();
            $prog = Programme::where('prog_code', $row['programme_code'])->where('prog_mode', $row['programme_mode'])->first();
            $data = new Student();
            $data->name = $row['student_name'];
            $data->email = $row['student_email'];
            $data->matricNo = $row['matricno'];
            $data->password = $row['password'];
            $data->phoneNo = $row['student_phoneno'];
            if($row['student_gender'] == "M")
            {
                $data->gender = "Male";
            }
            elseif($row['student_gender'] == "F")
            {
                $data->gender = "Female";
            }
            $data->status = 'Active';
            $data->role = 'Student';
            $data->semester_id = $sem->id;
            $data->programme_id = $prog->id;
            $data->titleOfResearch = $row['title_research'];

            $data->save();

            $staff = Staff::where('staffNo',$row['sv_id'])->first();
            $student = Student::where('matricNo',$row['matricno'])->first();

            $sv = new StudentStaff();
            $sv->student_id = $student->id;
            $sv->staff_id = $staff->id;
            $sv->supervision_role = "Supervisor";
            $sv->save();

            $costaff = Staff::where('staffNo',$row['cosv_id'])->first();
            $csv = new StudentStaff();
            $csv->student_id = $student->id;
            $csv->staff_id = $costaff->id;
            $csv->supervision_role = "Co-Supervisor";
            $csv->save();

            $data = DB::table('activity_programmes')
            ->join('activities','activity_programmes.activities_id','=','activities.id')
            ->join('documents','activity_programmes.activities_id','=','documents.activity_id')
            ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
            ->join('students','programmes.id','=','students.programme_id')
            ->where('students.matricNo','=',$row['matricno'])
            ->where('students.status','=','Active')
            ->select('students.id as studentsID','students.name','students.status','students.opcode','students.semcount','activity_programmes.activities_id','activity_programmes.timeline_sem','activity_programmes.timeline_week','activity_programmes.init_status','documents.doc_name','documents.id as docID')
            ->get(); 

            $currSem = Semester::where('status','Active')->first(); 

            $collection = collect([]);
            foreach($data as $item)
            {
                $check = Submission::where('student_id',$item->studentsID)->where('document_id',$item->docID)->exists();
                if(!$check)
                {
                    $days = $item->timeline_week * 7;
                    $currdate =  Carbon::parse($currSem->startdate);
                    $subDate = $currdate->addDays($days);
                    $collection->push(['submission_doc' => '-','submission_duedate' => $subDate,'submission_status' => $item->init_status ,'submission_final_form'=>'-','student_id'=>$item->studentsID, 'document_id'=>$item->docID ]);
                    Student::where('id',$item->studentsID)->update(['opcode'=>'0']);
                }

            } 

            Submission::insert($collection->all());

            
        }
        








    }
}
