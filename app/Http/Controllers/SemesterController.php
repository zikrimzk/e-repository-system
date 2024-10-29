<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('semesters as a')
                        ->select('a.id','a.label','a.startdate','a.enddate','a.status')
                        ->orderby('startdate','asc')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('startdate', function($row){
                $startdate = Carbon::parse($row->startdate)->format('d M Y h:i:s A');
                return $startdate;
            });
            $table->addColumn('enddate', function($row){
                $enddate = Carbon::parse($row->enddate)->format('d M Y h:i:s A');
                return $enddate;
            });
            $table->addColumn('duration', function($row){
                $duration = Carbon::parse($row->startdate)->diffInWeeks(Carbon::parse($row->enddate)) .' weeks';
                return $duration;
            });
            $table->addColumn('status', function($row){
                if($row->status == 'Inactive')
                {
                    $status = '<span class="badge bg-warning">'.$row->status.'</span>';
                }
                elseif($row->status == 'Prohibited')
                {
                    $status = '<span class="badge bg-danger">'.$row->status.'</span>';
                }
                else
                {
                    $status = '<span class="badge bg-success">'.$row->status.'</span>';
                }
                return $status;
          
            });

            $table->addColumn('action', function($row){
                $btn ='<a href="'.route('semesterUpdate', $row->id).'"
                class="btn btn-icon btn-sm btn-info-transparent rounded-pill"><i
                    class="ri-edit-line"></i></a>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->id.'">
                    <i class="ri-delete-bin-line"></i>
                    </button>

                    <script type="text/javascript">
                    $(document).ready(function(){
                        document.getElementById("alert-confirm'.$row->id.'").onclick = function () {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "'.$row->label.' will be removed. You cannot revert this action !",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route("semesterDelete",$row->id).'";
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
            $table->rawColumns(['startdate','enddate','duration','status','action']);
            return $table->make(true);
        }
        return view("programme.semester.index",[
            'title'=> 'e-Repo | Semester Management',
            'semester' => Semester::orderBy('startdate','asc')->get()
        ]);
    }

    public function gotoSemesterAdd()
    {
        return view("programme.semester.semesterAdd",[
            'title'=> 'e-Repo | Add Semester '
        ]);
    }

    public function Add(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'status' => 'required',
            'startdate' => 'required|date|',
            'enddate' => 'required|date|after:startdate',
          

        ]);

        Semester::create($validated);
        return redirect()->route('semesterManagement')->with('success','Semester details has successfully added !!');

    }

    public function gotoUpdate($id)
    {
        $semester = Semester::where('id',$id)->first();
        return view("programme.semester.semesterUpdate",[
            'title'=> 'e-Repo | Update Semester ',
            'semesters'=>$semester
        ]);
    }

    public function Update(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required',
            'status' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after:startdate',
          

        ]);
        Semester::where('id',$request->id)->update($validated);
        return redirect()->route('semesterManagement')->with('success','Semester details has successfully updated !');

    }
    public function DeleteSemester($id)
    {
        try
        {
            Semester::where('id',$id)->delete();
            return redirect()->route('semesterManagement')->with('success','Semester details has successfully deleted !');
        }
        catch(Exception $e)
        {
            return redirect()->route('semesterManagement')->with('success',$e->getMessage());
        }
       

    }

    public function CurrentSemester(Request $request)
    {
        try{

            if($request->id === null) {
                return back()->with('error','Please select new semester !');
            }
            $semcount = Student::where('status','=','Active')->select('id','semcount')->get();
            foreach($semcount as $sem) {
                Student::where('id','=',$sem->id)->update(['semcount'=> $sem->semcount + 1]);
            }
            Semester::where('status','Active')->update(['status' => 'Prohibited']);
            Semester::where('id',$request->id)->update(['status' => 'Active']);
            return back()->with('success', 'Current system semester has been set successfully !!');
    

        }
        catch(Exception $e){

            return back()->with('error', $e->getMessage());

        }
       
    }


}
