<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Faculty;
use App\Models\Programme; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProgrammeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('programmes as a')
                        ->join('faculties as b','a.fac_id','=','b.id')
                        ->select('a.id','a.prog_name','a.prog_code','a.prog_mode','b.fac_name as facname')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            
            $table->addColumn('action', function($row){
                $btn ='
                <div class="hstack gap-2 fs-15">
                    <a href = "'.route("programmeUpdate", $row->id).'" class="btn btn-icon btn-sm btn-info-transparent rounded-pill"><i class="ri-edit-line"></i></a>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->id.'"><i class="ri-delete-bin-line"></i></button>
                </div>
    
                <script type="text/javascript">
                    $(document).ready(function(){
                        document.getElementById("alert-confirm'.$row->id.'").onclick = function () {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "'.$row->prog_name.' programme will be removed. You cannot revert this action !",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route("programmeDelete",$row->id).'";
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
            $table->rawColumns(['action']);
            return $table->make(true);
        }
        return view("programme.course.index",[
            'title' => 'e-Repo | Programme Management ',
            'programme' => Programme::all()
        ]);
    }

    public function gotoProgrammeAdd()
    {
        return view("programme.course.programmeAdd",[
            'title' => 'e-Repo | Add Programme',
            'fac'=>Faculty::all()
        ]);
    }

    public function Add(Request $request)
    {
        $validated = $request->validate([
            'prog_code' => 'required',
            'prog_name' => 'required',
            'fac_id' => 'required',
            'prog_mode' => 'required',

        ]);

        Programme::create($validated);
        return redirect()->route('programmeManagement')->with('success','Programme details has successfully added !!');

    }

    public function gotoUpdate($id)
    {
        $prog = Programme::where('id',$id)->first();
        return view("programme.course.programmeUpdate",[
            'title'=> 'e-Repo | Update Programme ',
            'programme'=>$prog,
            'fac'=>Faculty::all()
        ]);
    }

    public function Update(Request $request,$id)
    {
        $validated = $request->validate([
            'prog_code' => 'required',
            'prog_name' => 'required',
            'fac_id' => 'required',
            'prog_mode' => 'required'

        ]);
        Programme::where('id',$id)->update($validated);
        return redirect()->route('programmeManagement')->with('success','Programme details has successfully updated !!');

    }

    public function Delete($id)
    {
        Programme::where('id',$id)->delete();
        return redirect()->route('programmeManagement')->with('success','Programme details has successfully deleted !!');

    }
}
