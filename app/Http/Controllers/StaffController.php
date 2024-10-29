<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Staff;
use App\Models\Student;
use App\Charts\StaffChart;
use App\Models\Department;
use App\Charts\StudentChart;
use App\Exports\StaffExport;
use App\Imports\StaffImport;
use App\Models\StudentStaff;
use Illuminate\Http\Request;
use App\Charts\StuSvSubChart;
use App\Charts\StudentSvChart;
use App\Exports\StaffTemplate;
use App\Models\PanelNomination;
use App\Charts\StuSvSubNoAChart;
use App\Mail\ResetPasswordStaff;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Charts\StudentProgrammeChart;

class StaffController extends Controller
{
    public function index(StudentProgrammeChart $chartstudent , StaffChart $chartstaff, StuSvSubChart $chartsvSub, StuSvSubNoAChart $chartsvnoSub, StudentChart $chartStudentP,StudentSvChart $chartSvStudentP)
    {
        //Count Total Student
        $TotalStudent   = Student::all()->count();
        $TotalStaff  = Staff::all()->count();
        $TotalSvStudent = DB::table('student_staff as a')
                                ->join('students as b','a.student_id','b.id')
                                ->where('b.status','Active')
                                ->where('a.supervision_role','Supervisor')
                                ->where('a.staff_id',auth()->user()->id)
                                ->count();
        $TotalCSvStudent = DB::table('student_staff as a')
                                ->join('students as b','a.student_id','b.id')
                                ->where('b.status','Active')
                                ->where('a.supervision_role','Co-Supervisor')
                                ->where('a.staff_id',auth()->user()->id)
                                ->count();
        $TotalAppStudent = DB::table('student_staff as a')
                                ->join('students as b','a.student_id','b.id')
                                ->join('student_activities as c','b.id','c.student_id')
                                ->where('b.status','Active')
                                ->where('c.ac_status','Confirmed')
                                ->where('a.supervision_role','Supervisor')
                                ->where('a.staff_id',auth()->user()->id)
                                ->count();
        $TotalAppStudentTDP = DB::table('student_staff as a')
                                ->join('students as b','a.student_id','b.id')
                                ->join('student_activities as c','b.id','c.student_id')
                                ->where('b.status','Active')
                                ->where('c.ac_status','Approved(SV)')
                                ->where('a.supervision_role','Supervisor')
                                ->count();
        $TotalNomStudent  = DB::table('students as a')
                                ->join('student_staff as d','a.id','=','d.student_id')
                                ->join('staff as e','d.staff_id','=','e.id')
                                ->join('activity_programmes as f','a.programme_id','f.programmes_id')
                                ->join('activities as g','f.activities_id','g.id')
                                ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                                ->where('d.staff_id','=',auth()->user()->id)
                                ->where('a.status','=','Active')
                                ->where('f.is_haveEva','=','1')
                                ->whereNotExists(function($query)
                                {
                                    $query->select(DB::raw('student_id'))
                                            ->from('panel_nominations')
                                            ->whereRaw('a.id = panel_nominations.student_id')
                                            ->whereRaw('g.id = panel_nominations.activity_id ');
                                })
                                ->count();
                                
        // dd($TotalNomStudent);
        return view("staff.index",[
            'title'=>' e-Repo | Staff Dashboard',
            'totalStudent'=>$TotalStudent,
            'totalStaff'=>$TotalStaff,
            'totalSv'=>$TotalSvStudent,
            'totalCSv'=>$TotalCSvStudent,
            'totalApp'=>$TotalAppStudent,
            'totalApptdp'=>$TotalAppStudentTDP,
            'totalNom'=>$TotalNomStudent,
            'chartstudent' => $chartstudent->build(),
            'chartstaff' => $chartstaff->build(),
            'chartsvsub' => $chartsvSub->build(),
            'chartsvnosub' => $chartsvnoSub->build(),
            'chartpstu' => $chartStudentP->build(),
            'chartsvpstu' => $chartSvStudentP->build(),








        ]);
    }

    public function gotoStaffManagement(Request $request) 
    {
        if ($request->ajax()) {
          
            $data = DB::table('staff as a')
                        ->join('departments as b','a.dep_id','=','b.id')
                        ->select('a.id','a.sname','a.staffNo','a.email','a.sphoneNo','b.dep_name as department','a.srole')
                        ->get();
            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('action', function($row){
       
                $btn = ' 
                <div class="hstack gap-2 fs-15">
                    <a href = "'.route("staffUpdate", $row->staffNo).'" class="btn btn-icon btn-sm btn-info-transparent rounded-pill"><i class="ri-edit-line"></i></a>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->staffNo.'"><i class="ri-delete-bin-line"></i></button>
                </div>
               
                <script type="text/javascript">
                $(document).ready(function(){
                    document.getElementById("alert-confirm'.$row->staffNo.'").onclick = function () {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "'.$row->sname.' will no longer get access in the system. You cannot revert this action !",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    location.href="'.route("staffDeletePost",$row->staffNo).'";
                                }, 1000);
                                
                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['action']);
            return $table->make(true);
        }
        return view("staff.staffList",[
            'title'=>' e-Repo | Staff Management',
            'staffs'=> Staff::all()
        ]);
    }

    public function gotoStaffRegistration()
    {
        return view("staff.staffAdd",[
            'title'=>' e-Repo | Staff Registration',
            'depts' => Department::all()
        ]);
    }

    public function Registration(Request $request)
    {
        try 
        {
            $validated = $request->validate([
                'staffNo' => 'required|unique:staff',
                'sname' => 'required',
                'email' => 'required|unique:staff',
                'sphoneNo' => 'required',
                'dep_id' => 'required',
                'password' => 'required|min:8',
                'srole' => 'required',
                'repassword' => 'required|min:8|same:password',
    
            ]);
    
            $validated['password'] = bcrypt($validated['password']);
            Staff::create($validated);
            return redirect(route('staffManagement'))->with('success','Success : Staff has successfully registered.');
        }
        catch(Exception)
        {
            return redirect(route('staffManagement'))->with('error','Error : There is a problem during the registration. Please try again !');
        }
       
    }

    public function gotoUpdate($staffs)
    {
        $details = Staff::where('staffNo', $staffs)->first();
        return view('staff.staffUpdate',[
            'title'=> 'e-Repo | Staff Update',
            'staff'=>$details,
            'depts' => Department::all()
        
        ]);
    }

    public function Update(Request $request)
    {
        $validated = $request->validate([
            'staffNo' => 'required',
            'sname' => 'required',
            'email' => 'required',
            'sphoneNo' => 'required',
            'dep_id' => 'required',
            'srole' => 'required',

        ]);

        Staff::where('staffNo', $request->staffNo)->update($validated);
        return redirect(route('staffManagement'))->with('success','Staff details has successfully updated !!');
       
    }

    public function Delete($id)
    {
        try{
            $delete = Staff::where('staffNo', $id)->first();
            $delete->delete();
            return back()->with('success','Staff deleted successfully !!');
        }
        catch(Exception $e){
            return back()->with('error','Error: There was an error occured during the delete process. It might cause because of the previous supervision record that the staff have being assigned and cannot be deleted.');
        } 
    }

    public function exportStaff()
    {
        return Excel::download(new StaffExport, 'staff-list.xlsx');
    }

    public function importStaff() 
    {
        try{
            Excel::import(new StaffImport,request()->file('file'));
            return back()->with('success','Data imported successfully !!');;
        }
        catch(Exception $e){
            return back()->with('error',$e->getMessage());
        }
      
    }
    public function exportStaffTemplate() 
    {
        return Excel::download(new StaffTemplate, 'staff-register.xlsx');
    }

    public function indexProfile()
    {
        return view('staff.staffprofile',[
            'title'=> 'e-Repo | Profile '
        ]);
    }

    public function indexProfileEdit()
    {
        return view('staff.staffprofileEdit',[
            'title'=> 'e-Repo | Profile Update'
        ]);
    }

    public function UpdateProfile(Request $request,$id)
    {
        try{
            $validated = $request->validate([
                'sname' => 'required',
                'email' => 'required',
                'sphoneNo' => 'required',
    
            ]);
    
            Staff::where('id', $id)->update($validated);
            return back()->with('success','Profile has been updated successfully !');

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
       
       
    }
    public function UpdatePassword(Request $request,$id)
    {
        try{
            
            $validated = $request->validate([
                'oldPass' => 'required | min:8',
                'newPass' => 'required | min:8',
                'renewPass' => 'required | same:newPass',
            ]);
            $check = Hash::check($validated['oldPass'], Auth::guard('staff')->user()->password, []);
            if($check)
            {
                Staff::where('id', $id)->update(['password'=> bcrypt($validated['renewPass'])]);
                return back()->with('success','Password has been changed successfully !');
            }
            else{
                return back()->with('error','Please enter the correct password !');
            }

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
       
       
    }

    public function indexResetPasswordRequest()
    {
       return view('staff.resetpasswordrequest',[
            'title'=>'e-Repo | Reset Password Request'
       ]);
    }
    public function indexResetPassword($id)
    {
        $data = Staff::where('id',$id)->first();
       return view('staff.resetpassword',[
            'title'=>'e-Repo | Reset Password',
            'data'=>$data

       ]);
    }


    public function resetPasswordMail(Request $request)
    {
        $data = $request->validate([
            'email'=>'required'
        ]);

        $check = Staff::where('email',$data['email'])->exists();
        if($check)
        {
            $data= Staff::where('email',$data['email'])->first();
            Mail::to($data['email'])->send(new ResetPasswordStaff($data));
            return back()->with('success','We have sent the reset link in the email registered. Please check your email !');
        }
        else
        {
            return back()->with('error','The email entered are not registered , Please contact committee for futher details , Thank you !');
        }

       
    }
    public function resetPassword(Request $request,$id)
    {
        try{
            
            $validated = $request->validate([
                'password' => 'required | min:8',
                'repassword' => 'required | same:password',
            ]);
           
            Staff::where('id', $id)->update(['password'=> bcrypt($validated['repassword'])]);
            return redirect()->route('staff.login')->with('success','Password has been changed successfully !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

       
    }
}
