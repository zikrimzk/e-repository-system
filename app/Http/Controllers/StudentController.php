<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Programme;
use App\Models\Submission;
use App\Models\StudentStaff;
use Illuminate\Http\Request;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Exports\StudentTemplate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentStaffExport;
use App\Imports\StudentStaffImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('semesters as c','a.semester_id','=','c.id')
                        ->select('a.id as stuID','a.name','a.matricNo','a.phoneNo','a.semcount','a.programme_id as progID','a.email','a.status',
                                 'b.prog_code as code','b.prog_mode as mode','c.label as sem')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('mode', function($row){
                if($row->mode == "PT")
                {
                    $badge = '<span class="badge rounded-pill bg-purple-transparent">Part-Time</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-purple">Full-Time</span>';
                }
                return $badge;
            });

            $table->addColumn('status', function($row){
                if($row->status == "Active")
                {
                    $badge = '<span class="badge rounded-pill bg-success">Active</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-danger">Inactive</span>';
                }
                return $badge;
            });

            $table->addColumn('action', function($row){
                if(Auth::guard('staff')->user()->srole !="Timbalan Dekan Pendidikan"){
                    $btn = ' 
                    <div class="hstack gap-2 fs-15">
                        <a href = "'.route("studentUpdate", $row->matricNo).'" class="btn btn-icon btn-sm btn-info-transparent rounded-pill"><i class="ri-edit-line"></i></a>
                        <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->matricNo.'"><i class="ri-delete-bin-line"></i></button>
                    </div>
                
                    <script type="text/javascript">
                        $(document).ready(function(){
                            document.getElementById("alert-confirm'.$row->matricNo.'").onclick = function () {
                                Swal.fire({
                                    title: "Are you sure?",
                                    text: "'.$row->name.' will no longer get access in the system. You cannot revert this action !",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes, delete it!"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        setTimeout(function() {
                                            location.href="'.route("removeStudent",$row->matricNo).'";  
                                        }, 1000);
                                        
                                    }
                                })
                            }
                        });
                    
                    </script>
                    ';
                }
                else
                {
                    $btn= '<span class="text-muted fs-12">Not Permited</span>';
                }
                return $btn;
            });
            $table->rawColumns(['mode','status','action']);
            return $table->make(true);
        }
        
        return view('staff.student.index',[
            'title'=> 'e-Repo | Student Management',
            'student'=>Student::all(),
            'prog'=>Programme::all()
        ]);
    }

    public function gotoStudentAdd()
    {
        $semester = Semester::where('status','Active')->first();
        $progs = Programme::all();

        return view("staff.student.studentAdd",[
            'title' => 'e-Repo | Student Registration',
            'sem'=> $semester,
            'progs'=> $progs

        ]);
    }

    public function Registration(Request $request)
    {
        $validated = $request->validate([
            'name'          =>  'required',
            'email'         =>  'required|unique:students',
            'matricNo'      =>  'required|unique:students',
            'phoneNo'       =>  'required',
            'gender'        =>  'required',
            'role'          =>  'required',
            'status'        =>  'required',
            'address'        => '',
            'semester_id'   =>  'required',
            'programme_id'  =>  'required', 
            'password'      =>  'required | min:8', 
            'repassword'    =>  'required | same:password',  


        ]);
        Student::create($validated);
        return redirect()->route('studentSubPost',$request->matricNo);

    }

    public function submissionRegister($id)
    {
        try{
            $data = DB::table('activity_programmes')
            ->join('activities','activity_programmes.activities_id','=','activities.id')
            ->join('documents','activity_programmes.activities_id','=','documents.activity_id')
            ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
            ->join('students','programmes.id','=','students.programme_id')
            ->where('students.matricNo','=',$id)
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
            return redirect()->route('studentManagement')->with('success','Student details has successfully registered !!');

        }
        catch(Exception $e){
            DB::rollback();
            return redirect()->route('studentManagement')->with('error',$e->getMessage());

        }
    }




    public function gotoUpdate($id)
    {
        $student = Student::where('matricNo',$id)->first();
        $semester = Semester::where('status','Active')->first();
        $progs = Programme::all();

        return view("staff.student.studentUpdate",[
            'title'=> 'e-Repo | Update Student Details ',
            'students'=>$student,
            'sem'=> $semester,
            'progs'=> $progs
        ]);
    }

    public function Update(Request $request)
    {
        $validated = $request->validate([
            'name'          =>  'required',
            'email'         =>  'required',
            'matricNo'      =>  'required',
            'phoneNo'       =>  'required',
            'gender'        =>  'required',
            'role'          =>  'required',
            'status'        =>  'required',
            'address'        => '',
            'programme_id'  =>  'required',
        ]);
        Student::where('matricNo',$request->matricNo)->update($validated);
        return redirect()->route('studentManagement')->with('success','Student details has successfully updated !!');

    }

    public function Remove($id)
    {
        try{
            $delete = Student::where('matricNo', $id)->first();
            $delete->delete();
            return back()->with('success','Student deleted successfully !!');
        }
        catch(Exception $e){
            return back()->with('error','Error: Student details cannot be deleted.');
        }
        
       
    }


    public function gotoSupervision(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('student_staff as a')
                        ->join('students as b','a.student_id','=','b.id')
                        ->join('programmes as c','b.programme_id','=','c.id')
                        ->join('semesters as d','b.semester_id','=','d.id')
                        ->join('staff as e','a.staff_id','=','e.id')
                        ->where('b.status','Active')
                        ->select(
                            'a.student_id as studID',
                            'a.staff_id as staffID',
                            'a.supervision_role as svrole',
                            'b.titleOfResearch as title',
                            'b.name as stuname',
                            'b.email as stuemail',
                            'b.phoneNo as stuphone',
                            'b.matricNo as stumatric',
                            'c.prog_code as code',
                            'c.prog_mode as mode',
                            'd.label as label',
                            'e.sname as staname'

                        )
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('mode', function($row){
                if($row->mode == "PT")
                {
                    $badge = '<span class="badge rounded-pill bg-purple-transparent">Part-Time</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-purple">Full-Time</span>';
                }
                return $badge;
            });
            $table->addColumn('svrole', function($row){
                if($row->svrole == "Supervisor")
                {
                    $sv = '<span class="badge rounded-pill bg-success">'.$row->svrole.'</span>';
                }
                elseif($row->svrole == "Co-Supervisor")
                {
                    $sv = '<span class="badge rounded-pill bg-success-transparent">'.$row->svrole.'</span>';
                }
                else
                {
                    $sv = '<span class="badge rounded-pill bg-purple-transparent">'.$row->svrole.'</span>';
                }
                return $sv;

            });
            $table->addColumn('btntitle', function($row){
                
                $btnt = '<a class="modal-effect btn btn-icon btn-sm btn-transparent rounded-pill"data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalTitleEdit'.$row->stumatric.'"><i class="ri-edit-line"></i></a>';
                return $btnt;

            });
            $table->addColumn('action', function($row){
       
                $btn = ' 
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-primary-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate'.$row->stumatric.$row->staffID.'"><i class="ri-edit-line"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->studID.$row->staffID.'"><i class="ri-delete-bin-line"></i></button>
                </div>
               
                <script type="text/javascript">
                $(document).ready(function(){
                    document.getElementById("alert-confirm'.$row->studID.$row->staffID.'").onclick = function () {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You cannot revert this action !",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    location.href="'.route("removeSupervision",["stud"=>$row->studID , "sta" =>$row->staffID]).'";
                                }, 1000);
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                )
                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['mode','btntitle','svrole','action']);
            return $table->make(true);
        }
        $stusta = DB::table('student_staff as a')
                        ->join('students as b','a.student_id','=','b.id')
                        ->join('programmes as c','b.programme_id','=','c.id')
                        ->join('semesters as d','b.semester_id','=','d.id')
                        ->join('staff as e','a.staff_id','=','e.id')
                        ->select(
                            'a.student_id as studID',
                            'a.staff_id as staffID',
                            'a.supervision_role as svrole',
                            'b.titleOfResearch as title',
                            'b.name as stuname',
                            'b.email as stuemail',
                            'b.phoneNo as stuphone',
                            'b.matricNo as stumatric',
                            'c.prog_code as code',
                            'c.prog_mode as mode',
                            'd.label as label',
                            'e.sname as staname'

                        )
                        ->get();
        return view('staff.student.studentSupervision',[
            'title'=> 'e-Repo | Supervision & Evaluation Arrangement',
            'student'=>Student::orderByDesc('created_at')->get(),
            'studentsv'=>$stusta,
            'staff'=> Staff::whereIn('srole',['Committee','Lecturer'])->get(),
            'stusta'=>StudentStaff::orderByDesc('supervision_role')->get()
        ]);
    }

    public function Supervision(Request $request)
    {
        if($request->staff_id == null || $request->supervision_role == null)
        {
            return back()->with('error','Please complete all the require input !.');
        }
        $validated = $request->validate([
            'student_id'                =>  'required',
            'staff_id'                  =>  'required',
            'supervision_role'          =>  'required', 
        ]);

        $data = new StudentStaff;
        $data->student_id = $validated['student_id'];
        $data->staff_id = $validated['staff_id'];
        $data->supervision_role = $validated['supervision_role'];
        $data->save();

        return back()->with('success','Student has successfully being assigned !!');
        
    }

    public function SupervisionUpdate(Request $request)
    {
        if($request->staff_id == null || $request->supervision_role == null)
        {
            return back()->with('error','Please complete all the require input !.');
        }
        StudentStaff::where('student_id', $request->student_id)
                        ->where('supervision_role' ,$request->supervision_role)
                        ->update(['staff_id' => $request->staff_id]);

        return back()->with('success','Customize operation successfull !!');
        
    }
    public function SupervisionRemove($stud,$sta)
    {
        if($stud == null || $sta == null)
        {
            return back()->with('error','Remove operation was unsuccessfully , Please Try again !');
        }
        StudentStaff::where('student_id', $stud)->where('staff_id' ,$sta)->delete();
        return back()->with('success','Remove operation successfully executed !');
        
    }

    public function TitleUpdate(Request $request)
    {
        if($request->titleOfResearch == null)
        {
            return back()->with('error','Please complete the require input !.');
        }

        Student::where('id', $request->id)->update(['titleOfResearch' => $request->titleOfResearch]);

        return back()->with('success','Title updated successfull !!');
        
    }

    public function importStudent() 
    {
        try{
            Excel::import(new StudentImport,request()->file('file'));
            return back()->with('success','Data imported successfully !!');;
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
      
    }
    public function exportStudent() 
    {
        return Excel::download(new StudentExport, 'student-list.xlsx');
    }

    public function exportStudentTemplate() 
    {
        return Excel::download(new StudentTemplate, 'student-register.xlsx');
    }

    public function exportSupervision() 
    {
        return Excel::download(new StudentStaffExport, 'student-supervision.xlsx');
    }

    public function importSupervision() 
    {
        try{
            Excel::import(new StudentStaffImport,request()->file('file'));
            return back()->with('success','Data imported successfully !!');;
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
      
    }




}
