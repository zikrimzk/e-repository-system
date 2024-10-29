<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Form;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Evaluator;
use Illuminate\Http\Request;
use App\Models\ActivityProgramme;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EvaluationController extends Controller
{
    public function indexEva(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('evaluators as a')
                        ->join('students as b','a.student_id','b.id')
                        ->join('staff as c','a.staff_id','c.id')
                        ->join('activities as d','a.activity_id','d.id')
                        ->join('programmes as e','b.programme_id','=','e.id')
                        ->select(
                                'a.id as evaID',
                                'b.id as studID',
                                'c.id as staffID',
                                'd.id as actID',
                                'd.act_name as actname',
                                'b.name',
                                'b.matricNo',
                                'e.prog_code',
                                'e.prog_mode',
                                'c.sname',
                                'a.eva_role as evarole'
                            )
                            ->get();
        
    
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('evarole', function($row){
                if($row->evarole == 'Examiner 1')
                {
                    $role = '<span class="badge rounded-pill bg-success">'.$row->evarole.'</span>';
                }
                elseif($row->evarole == 'Chair')
                {
                    $role = '<span class="badge rounded-pill bg-success-gradient">'.$row->evarole.'</span>';
                }
                else
                {
                    $role = '<span class="badge rounded-pill bg-success-transparent">'.$row->evarole.'</span>';
                }
                return $role;
            });

        
            $table->addColumn('action', function($row){
               
                $button = '
                <div class="hstack gap-2 fs-15">
                    <button class="btn btn-icon btn-sm btn-primary-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate'.$row->evaID.'"><i class="ri-edit-line"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" id="alert-remove'.$row->evaID.'"><i class="ri-delete-bin-line"></i></button>
                </div>
               
                <script type="text/javascript">
                    $(document).ready(function(){
                        document.getElementById("alert-remove'.$row->evaID.'").onclick = function () {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "You cannot revert this action !",
                                icon: "info",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, delete !"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route('evaDeleteGet',$row->evaID).'";
                                    }, 1000);
                                }
                            })
                        }

                    });
                
                </script>
                ';
               
                return $button;
            });
            $table->rawColumns(['evarole','action']);
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
            $student = DB::table('students as a')
                        ->join('panel_nominations as b','a.id','=','b.student_id')
                        ->join('activities as c','b.activity_id','=','c.id')
                        ->join('programmes as d','a.programme_id','=','d.id')
                        ->whereIn('b.nom_status', ['Approved'])
                        ->select('a.id as stuID','a.name')
                        ->get();
            $activity = DB::table('activity_programmes as a')
                            ->join('activities as c','a.activities_id','=','c.id')
                            ->where('is_haveEva','1')
                            ->select('a.activities_id as actID','c.act_name as actname')
                            ->get();
            $modalUpdate = DB::table('evaluators')
                                ->get();
      
        return view('staff.evaluation.index',[
            'title'=>'e-Repo | Evaluation Arragement',
            'student'=>$student->unique()->values(),
            'studentsv'=>$stusta,
            'staff'=> Staff::whereIn('srole',['Committee','Lecturer'])->get(),
            'activity'=>$activity->unique()->values(),
            'eva'=>$modalUpdate
        ]);
    }

    public function addEva(Request $request)
    {
        try{
            $validated = $request->validate([
                'student_id'   =>'required',
                'staff_id'     =>'required',
                'activity_id'  =>'required',
                'eva_role'     =>'required',
            ]);

            $check = DB::table('evaluators')
                        ->where('student_id',$request->student_id)
                        ->where('staff_id',$request->staff_id)
                        ->where('activity_id',$request->activity_id)
                        ->exists();
            if(!$check)
            {
                Evaluator::create($validated);
                return back()->with('success','Evaluator has been set successfully');
            }
            else
            {
                return back()->with('error','The evaluator has been set already !');
            }


        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }

    public function updateEva(Request $request,$id)
    {
        try{
            $validated = $request->validate([
                'student_id'   =>'required',
                'staff_id'     =>'required',
                'activity_id'  =>'required',
                'eva_role'     =>'required',
            ]);
            
            Evaluator::where('id',$id)->update($validated);
            return back()->with('success','Evaluator has been updated successfully');
          
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }

    public function deleteEva($id)
    {
        try{
           
            Evaluator::where('id',$id)->delete();
            return back()->with('success','Evaluator has been deleted successfully');
          
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }

    public function indexMyEva($id)
    {
        $chair = DB::table('evaluators as a')
                        ->join('students as b','a.student_id','b.id')
                        ->join('staff as c','a.staff_id','c.id')
                        ->join('activities as d','a.activity_id','d.id')
                        ->where('a.staff_id','=',auth()->user()->id)
                        ->where('a.activity_id','=',$id)
                        ->where('a.eva_role','=','Chair')
                        ->join('programmes as e','b.programme_id','=','e.id')
                        ->select(
                                'a.id as evaID',
                                'b.id as studID',
                                'c.id as staffID',
                                'd.id as actID',
                                'd.act_name as actname',
                                'b.name',
                                'b.matricNo',
                                'e.prog_code',
                                'e.prog_mode',
                                'c.sname',
                                'a.eva_role as evarole',
                                'a.eva_status as evastatus',
                                'a.eva_doc as evadoc',

                            )
                            ->get();
    
        $examiner = DB::table('evaluators as a')
                            ->join('students as b','a.student_id','b.id')
                            ->join('staff as c','a.staff_id','c.id')
                            ->join('activities as d','a.activity_id','d.id')
                            ->where('a.staff_id','=',auth()->user()->id)
                            ->where('a.activity_id','=',$id)
                            ->whereIn('a.eva_role',['Examiner 1','Examiner 2'])
                            ->join('programmes as e','b.programme_id','=','e.id')
                            ->select(
                                    'a.id as evaID',
                                    'b.id as studID',
                                    'c.id as staffID',
                                    'd.id as actID',
                                    'd.act_name as actname',
                                    'b.name',
                                    'b.matricNo',
                                    'e.prog_code',
                                    'e.prog_mode',
                                    'c.sname',
                                    'a.eva_role as evarole',
                                    'a.eva_status as evastatus',
                                    'a.eva_doc as evadoc',
                                )
                                ->get();
        $actname = Activity::where('id',$id)->first()->act_name;
        $formchair = Form::where('activity_id',$id)->where('form_appearance','EvaChair')->where('form_isShow','1')->get();
        $formexa = Form::where('activity_id',$id)->where('form_appearance','EvaExa')->where('form_isShow','1')->get();

        return view('staff.myevaluation.index',[
            'title'=>'e-Repo | Evaluation',
            'id'=>$id,
            'data'=>$chair,
            'data2'=>$examiner,
            'actname'=>$actname,
            'formchair'=>$formchair,
            'formexa'=>$formexa 

        ]);
    }

    public function uploadMyEva(Request $request,$id)
    {

        try
        {
            $request->validate([
                'eva_doc'=>'required'
            ]);
            $details =  Evaluator::where('id',$id)->first();

            $student = DB::table('students')
            ->where('id',$details->student_id)
            ->first();

            $acts = DB::table('activities')
            ->where('id',$details->activity_id)
            ->first();

            $file = $request->file('eva_doc');
            $filename =$student->matricNo.'_'.str_replace(' ','',$acts->act_name).str_replace(' ','',$details->eva_role).'.'. $file->getClientOriginalExtension();
            $file->move(public_path('EvaluationForm'),$filename);

            Evaluator::where('id',$id)->update(['eva_status'=>'Completed', 'eva_doc' =>$filename]);
            return back()->with('success','Evaluation form has been uploaded successfully');
        }
        catch(Exception $e)
        {   
            return back()->with('error',$e->getMessage());
        }

    }

    public function downloadEvaForm($id)
    {
        try{
            $file = Evaluator::where('id' , $id)->first();
            return response()->download(public_path('EvaluationForm/'.$file->eva_doc));

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }
}
