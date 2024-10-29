<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Form;
use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function index(Request $request){
    
        $form =DB::table('forms as a')
                    ->join('activities as b','a.activity_id','=','b.id')
                    ->select(
                        'a.id as formID',
                        'a.form_name as fname',
                        'a.form_doc as fdoc',
                        'a.form_appearance as fappearance',
                        'a.form_isShow as isShow',
                        'b.act_name','b.id as actID'
                        )
                    ->get();
        if ($request->ajax()) {
          
            $data = DB::table('forms as a')
                        ->join('activities as b','a.activity_id','=','b.id')
                        ->select('a.id as formID',
                        'a.form_name as fname',
                        'a.form_doc as fdoc',
                        'a.form_appearance as fappearance',
                        'a.form_isShow as isShow',
                        'b.act_name'
                        )
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('fappearance', function($row){
                if($row->fappearance == "AS")
                {
                    $text = 'After Submission';
                }
                elseif($row->fappearance == "ARD")
                {
                    $text = 'After Reject Document';
                }
                elseif($row->fappearance == "NOM")
                {
                    $text = 'Nomination';
                }
                else
                {
                    $text = 'Others';
                }
                return $text;
            });
            $table->addColumn('isShow', function($row){
                if($row->isShow == 1)
                {
                    $badge = '<span class="badge rounded-pill bg-success">Show</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-danger">Hidden</span>';
                }
                return $badge;
            });

            $table->addColumn('action', function($row){
       
                $btn =
                ' 
                <div class="hstack gap-2 fs-15">
                    <a class="btn btn-icon btn-sm btn-info-transparent rounded-pill" 
                    data-bs-toggle="modal" data-bs-target="#modalupdate'.$row->formID.'">
                    <i class="ri-edit-line"></i>
                    </a>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-confirm'.$row->formID.'">
                    <i class="ri-delete-bin-line"></i>
                    </button>
                </div>

                <script type="text/javascript">
                $(document).ready(function(){
                    document.getElementById("alert-confirm'.$row->formID.'").onclick = function () {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "'.$row->fname.' documents will be remove completely. You cannot revert this action !",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function() {
                                    location.href="'.route("formDeletePost",$row->formID).'";
                                }, 1000);
                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['isShow','action']);
            return $table->make(true);
        }
        return view('submission.form.index',[
            'title'=>'e-Repo | Form Setting',
            'acts'=>Activity::all(),
            'forms'=>$form
        ]);
    }

    public function addForm(Request $request){

        try
        {
            $validated = $request->validate([
                'form_name'=> 'required',
                'form_appearance'=> 'required',
                'form_isShow'=> 'required',
                'activity_id'=> 'required',

            ]);
            if($request->file('form_doc') != null)
            {
                $file = $request->file('form_doc');
                $filename = str_replace(' ', '', $validated['form_name']).'.'. $file->getClientOriginalExtension();
                $file->move(public_path('ActivityForm'),$filename);
                $validated['form_doc'] = $filename;
            }
            else
            {
                return back()->with('error', 'Error: No Form uploaded. Please try again !');
            }
        
            Form::create($validated);
            return back()->with('success', 'Success: Form has successfully being added !!');
        }
        catch(Exception $e)
        {
            return back()->with('error','Error: '.$e->getMessage());
        }
      
    }

    public function updateForm(Request $request,$id){
        try
        {
            $validated = $request->validate([
                'form_name'=> 'required',
                'form_appearance'=> 'required',
                'form_isShow'=> 'required',
                'activity_id'=> 'required',
            ]);
            if($request->file('form_doc') != null)
            {
                $file = $request->file('form_doc');
                $filename = str_replace(' ', '', $validated['form_name']).'.'. $file->getClientOriginalExtension();
                $file->move(public_path('ActivityForm'),$filename);
                $validated['form_doc'] = $filename;
            }
            Form::where('id',$id)->update($validated);
            return back()->with('success', 'Success: Form has successfully updated !!');
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
      
    }
    public function removeForm($id)
    {
        try{
            $delete = Form::where('id', $id)->first();
            $delete->delete();
            return back()->with('success','Success: Form deleted successfully !!');
        }
        catch(Exception $e){
            return back()->with('error','Error: There is a problem during delete operation. Please try again !');
        }
        
       
    }
}
