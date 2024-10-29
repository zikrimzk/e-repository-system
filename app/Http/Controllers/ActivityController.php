<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Programme;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ActivityProgramme;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
          
            $data = DB::table('activities as a')
                        ->select('a.id','a.act_name as actname','a.created_at as date')
                        ->get();
                    
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('date', function($row){
                return Carbon::parse($row->date)->format('d M Y , h:i A');
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
                                    location.href="'.route("activityDeletePost",$row->id).'";
                                }, 1000);
                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['date','action']);
            return $table->make(true);
        }
        return view("submission.activity.index",[
            'title'=>'e-Repo | Activity Setting',
            'act'=> Activity::orderBy('created_at','desc')->get(),
            'doc'=> Document::select('activity_id')->get(),
            'actdoc'=>ActivityProgramme::select('activities_id')->get()

        ]);
    }

    public function Add(Request $request){
        try{
            $validated = $request->validate([
                'act_name'=>'required'
               ]);
               Activity::create($validated);
               return back()->with('success','Success: Activity has successfully added !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        }
       
    }

    public function Update(Request $request){
       
        try{
            $validated = $request->validate([
                'act_name'=>'required'
               ]);
               Activity::where('id', $request->id)->update($validated);
               return back()->with('success','Success: Activity has successfully updated !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        }
     }

    public function Delete($id)
    {
        try{
            $delete = Activity::where('id', $id)->first();
            $delete->delete();
            return back()->with('success','Success: Activity has successfully deleted !');
        }
        catch(Exception $e){
            return back()->with('error', 'Error: There is a problem during delete operation. Please try again !');
        } 
    }


    //Activity Programme Controller Part


    public function indexProcedure(Request $request){
        if ($request->ajax()) {
          
            $data = DB::table('activity_programmes')
                        ->join('activities','activity_programmes.activities_id','=','activities.id')
                        ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
                        ->select('activities.act_name as actname','activities.id','programmes.prog_code as progcode',
                        'programmes.prog_name as progname','programmes.prog_mode as progmode','programmes.id',
                        'activity_programmes.activities_id','activity_programmes.programmes_id',
                        'activity_programmes.timeline_sem as sem','activity_programmes.timeline_week as week',
                        'activity_programmes.init_status as status','activity_programmes.meterial as material',
                        'activity_programmes.act_seq as actseq','activity_programmes.is_haveEva as hasEva')
                        ->get();
                    
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('hasEva', function($row){
                if($row->hasEva == "0")
                {
                    $badge = '<span class="badge rounded-pill bg-danger">No</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-success">Yes</span>';
                }
                return $badge;
            });
            $table->addColumn('status', function($row){
                if($row->status == "Locked")
                {
                    $badge = '<span class="badge rounded-pill bg-danger">L</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-success">O</span>';
                }
                return $badge;
            });
            $table->addColumn('material', function($row){
                if($row->material != null)
                {
                    $mat = '<a href="'.route('materialDownAct',['act'=>$row->activities_id, 'prog'=>$row->programmes_id]).'" 
                    class=" btn me-0 btn-primary-transparent  btn-sm"> Download </a>';
                }
                else
                {
                    $mat = '';
                }
                return $mat;
            });
            $table->addColumn('action', function($row){
       
                $btn = ' 
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-info-transparent rounded-pill" 
                    data-bs-toggle="modal" data-bs-target="#modalUpdate-'.$row->activities_id.'-'.$row->programmes_id.'">
                    <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" 
                    id="alert-confirm'.$row->activities_id.'-'.$row->programmes_id.'">
                    <i class="ri-delete-bin-line"></i>
                    </button>
                </div>

                <script type="text/javascript">
                $(document).ready(function(){
                    document.getElementById("alert-confirm'.$row->activities_id.'-'.$row->programmes_id.'").onclick = function () {
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
                                    location.href="'.route("proDeletePost",['act'=>$row->activities_id , 'prog'=>$row->programmes_id]).'";
                                }, 1000);
                            }
                        })
                    }
                });
                
                </script>
                ';
                return $btn;
            });
            $table->rawColumns(['hasEva','material','status','action']);
            return $table->make(true);
        }
        $actdoc = DB::table('activity_programmes')
                        ->join('activities','activity_programmes.activities_id','=','activities.id')
                        ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
                        ->select('activities.act_name','activities.id','programmes.prog_code','programmes.prog_mode',
                        'programmes.id','activity_programmes.activities_id','activity_programmes.programmes_id',
                        'activity_programmes.timeline_sem','activity_programmes.timeline_week',
                        'activity_programmes.meterial as material','activity_programmes.act_seq as actseq',
                        'activity_programmes.init_status','activity_programmes.is_haveEva')
                        ->get();
        

        return view("submission.procedure.index",[
            'title'=>'e-Repo | Procedure Management',
            'actdoc'=> $actdoc,
            'acts'=> Activity::orderBy('created_at','desc')->get(),
            'progs'=> Programme::orderBy('prog_name','asc')->get(),

 
        ]);
    }

    public function AddProcedure(Request $request){
        try{
            $validated = $request->validate([
                'activities_id'    =>  'required',
                'programmes_id'    =>  'required',
                'act_seq'          =>  'required|numeric',
                'timeline_sem'     =>  'required|numeric',
                'timeline_week'    =>  'required|numeric',
                'init_status'      =>  'required',
                'is_haveEva'       =>  'required',
                'meterial'         =>  '',
               ]);
               if($request->meterial != null) 
               {
                   $act_name = Activity::where('id',$request->activities_id)->first()->act_name;
                   $prog = Programme::where('id',$request->programmes_id)->first();
                   $material = $request->meterial;
                   $filename = str_replace(' ', '', $act_name).'_'.$prog->prog_code.'('.$prog->prog_mode.')'.'_Flowchart'.'.'. 
                   $material->getClientOriginalExtension();
                   $request->meterial->move('material',$filename);
                   $validated['meterial'] = $filename;
           
               } 
               $check = ActivityProgramme::where('activities_id', $request->activities_id)
                       ->where('programmes_id',$request->programmes_id)
                       ->exists();
       
               if($check) {
                   return back()->with('error','Error: Procedure has been set already !');
               }
        
               ActivityProgramme::create($validated);
            return back()->with('success','Success: Procedure has been set successfully !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        } 
       
     }

     public function UpdateProcedure(Request $request){
        try{
            $validated = $request->validate([
                'activities_id'    =>  'required',
                'programmes_id'    =>  'required',
                'act_seq'          =>  'required|numeric',
                'timeline_sem'     =>  'required|numeric',
                'timeline_week'    =>  'required|numeric',
                'init_status'      =>  'required',
                'is_haveEva'       =>  'required',
                'meterial'         =>  '',
            ]);
            if($request->meterial != null) 
            {
                $act_name = Activity::where('id',$request->activities_id)->first()->act_name;
                $prog = Programme::where('id',$request->programmes_id)->first();
                $material = $request->meterial;
                $filename = str_replace(' ', '', $act_name).'_'.$prog->prog_code.'('.$prog->prog_mode.')'.'_Flowchart_Updated'.'.'. 
                $material->getClientOriginalExtension();
                $request->meterial->move('material',$filename);
                $validated['meterial'] = $filename;
            }
            ActivityProgramme::where('activities_id', $request->activities_id)
                                ->where('programmes_id',$request->programmes_id)
                                ->update($validated);
            return back()->with('success','Success: Procedure has been updated successfully !');
        }
        catch(Exception $e){
            return back()->with('error','Error: '.$e->getMessage());
        } 
        
     }


     public function DeleteProcedure($act,$prog)
     {
         try{
             ActivityProgramme::where('activities_id', $act)
             ->where('programmes_id',$prog)
             ->delete();
             return back()->with('success','Success: Procedure deleted successfully !!');
         }
         catch(Exception $e){
            return back()->with('error', 'Error: There is a problem during delete operation. Please try again !');
         } 
     }

     public function downloadsMaterial($act , $prog)
     {
        // $file = ActivityProgramme::where('activities_id' , $act)->where('programmes_id',$prog)->first();
        // dd($file->meterial);
        try
        {
             $file = ActivityProgramme::where('activities_id' , $act)->where('programmes_id',$prog)->first();
             return response()->download(public_path('material/'.$file->meterial));
        }
        catch(Exception $e)
        {
             return back()->with('error','Error: File do not exists !');
        }
         
     }

    
}
