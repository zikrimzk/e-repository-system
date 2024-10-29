<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request){
        
        if ($request->ajax()) {
          
            $data = DB::table('departments as a')
                        ->join('faculties as b','a.fac_id','=','b.id')
                        ->select('a.id','a.dep_name','b.fac_name as facname','a.created_at')
                        ->orderby('created_at','asc')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('created_at', function($row){
                $createddate = Carbon::parse($row->created_at)->format('d M Y h:i:s A');
                return $createddate;
            });
            
            $table->addColumn('action', function($row){
                $btn ='
                    <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate'.$row->id.'">
                        <i class="ri-edit-line"></i>
                    </button>

                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->id.'">
                        <i class="ri-delete-bin-line"></i>
                    </button>

                    <script type="text/javascript">
                    $(document).ready(function(){
                        document.getElementById("alert-confirm'.$row->id.'").onclick = function () {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "'.$row->dep_name.' will be removed. You cannot revert this action !",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route("depDelete",$row->id).'";
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
            $table->rawColumns(['created_at','action']);
            return $table->make(true);
        }
        return view('programme.department.index',[
            'title'=>'e-Repo | Department Setting ',
            'deps'=>Department::all(),
            'facs'=>Faculty::all()
        ]);
    }

    public function Add(Request $request)
    {
        try{
            $validated = $request->validate([
                'dep_name'=>'required',
                'fac_id'=>'required'

            ]);
            
            Department::create($validated);
            return back()->with('success','Department details has been successfully Added !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
        

    }

    public function Update(Request $request,$id)
    {
        try{
            $validated = $request->validate([
                'dep_name'=>'required',
                'fac_id'=>'required'

            ]);
            Department::where('id',$id)->update($validated);
            return back()->with('success','Department details has been successfully updated !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
        

    }

    public function Delete($id)
    {
        try{
            Department::where('id',$id)->delete();
            return back()->with('success','Department details has been successfully removed !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
        

    }
}
