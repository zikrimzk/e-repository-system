<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('faculties as a')
                        ->select('a.id','a.fac_name','a.fac_code')
                        ->orderby('created_at','desc')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
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
                                text: "'.$row->fac_name.' will be removed. You cannot revert this action !",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route("facDelete",$row->id).'";
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
        return view ('programme.faculty.index',[
            'title'=>'e-Repo | Faculty Setting',
            'facs'=>Faculty::all()
        ]);
    }

    public function Add(Request $request)
    {
        try{
            $validated = $request->validate([
                'fac_name'=>'required',
                'fac_code'=>'required'

            ]);
            
            Faculty::create($validated);
            return back()->with('success','Faculty details has been successfully added !');
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
                'fac_name'=>'required',
                'fac_code'=>'required'

            ]);
            
            Faculty::where('id',$id)->update($validated);
            return back()->with('success','Faculty details has been successfully updated !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
        

    }

    public function Delete($id)
    {
        try{
            Faculty::where('id',$id)->delete();
            return back()->with('success','Faculty details has been successfully removed !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
        

    }
}
