<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Activity;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
          
            $data = DB::table('documents as a')
                        ->join('activities as b','a.activity_id','=','b.id')
                        ->select(
                            'a.id',
                            'a.doc_name as docname',
                            'a.isRequired as required',
                            'a.isShowDoc as showdoc',
                            'b.act_name as actname'
                        )
                        ->get();
                    
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('showdoc', function($row){
                if($row->showdoc == 0)
                {
                    $badge = '<span class="badge rounded-pill bg-danger">No</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-success">Yes</span>';
                }
                return $badge;
            });
            $table->addColumn('required', function($row){
                if($row->required == 0)
                {
                    $badge = '<span class="badge rounded-pill bg-danger">No</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-success">Yes</span>';
                }
                return $badge;
            });
            $table->addColumn('action', function($row){
       
                $btn = ' 
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill" data-bs-toggle="modal" 
                    data-bs-target="#modalUpdate'.$row->id.'">
                    <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->id.'">
                    <i class="ri-delete-bin-line"></i>
                    </button>
                </div>

                <script type="text/javascript">
                $(document).ready(function(){
                    document.getElementById("alert-confirm'.$row->id.'").onclick = function () {
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
                                    location.href="'.route("docDeletePost",$row->id).'";
                                }, 1000);

                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['showdoc','required','action']);
            return $table->make(true);
        }
        
        return view("submission.document.index",[
            'title'=>'e-Repo | Document Setting',
            'docs'=> Document::all(),
            'acts'=> Activity::all(),
        ]);
    }

    public function Add(Request $request){
        try
        {
            $validated = $request->validate([
                'doc_name'=>'required',
                'activity_id'=>'required',
                'isShowDoc'=>'required',
                'isRequired'=>'required'
    
            ]);
            Document::create($validated);
            return back()->with('success','Success: Document has successfully added !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        }
        
     }
 
    public function Update(Request $request){
        
        try
        {
            $validated = $request->validate([
                'doc_name'=>'required',
                'activity_id'=>'required',
                'isShowDoc'=>'required',
                'isRequired'=>'required'
            ]);
      
            Document::where('id', $request->id)->update($validated);
            return back()->with('success','Success: Document has successfully updated !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        }
      }
 
    public function Delete($id)
    {
        try{
             $delete = Document::where('id', $id)->first();
             $delete->delete();
             return back()->with('success','Success: Document has successfully deleted !');
        }
        catch(Exception $e){
            return back()->with('error','Error: There is a problem during delete operation. Please try again !');
        } 
    }
}
