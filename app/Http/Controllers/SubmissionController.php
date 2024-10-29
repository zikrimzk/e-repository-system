<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Semester;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Mail\SubmissionNotify;
use App\Models\ActivityProgramme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class SubmissionController extends Controller
{
    public function indexSubmission(Request $request){
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('submissions as f','a.id','=','f.student_id')
                        ->join('documents as g','f.document_id','=','g.id')
                        ->where('a.status','=','Active')
                        ->select(
                            'a.id as stuID',
                            'a.name',
                            'a.matricNo',
                            'a.phoneNo',
                            'a.semcount',
                            'a.programme_id as progID',
                            'a.email',
                            'a.status',
                            'b.prog_code as code',
                            'b.prog_mode as mode',
                            'f.id as subID',
                            'f.submission_doc as subdoc',
                            'f.submission_date as subdate',
                            'f.submission_duedate as subduedate',
                            'f.submission_status as substatus',
                            'g.doc_name as docname'
                            )
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('subduedate', function($row){
                $date= Carbon::parse($row->subduedate)->format('d M Y , h:i A');
                return $date;
            });
            $table->addColumn('substatus', function($row){
                if($row->substatus == "Locked" || $row->substatus == "Rejected")
                {
                    $status = '<span class="badge rounded-pill bg-danger">'.$row->substatus.'</span>';
                }
                elseif($row->substatus == "No Attempt")
                {
                    $status = '<span class="badge rounded-pill bg-warning">'.$row->substatus.'</span>';
                }
                elseif($row->substatus == "Overdue" || $row->substatus == "Not Submitted" )
                {
                    $status = '<span class="badge rounded-pill bg-danger-transparent">'.$row->substatus.'</span>';
                }
                else
                {
                    $status = '<span class="badge rounded-pill bg-success">'.$row->substatus.'</span>';
                }
                return $status;

            });
            $table->addColumn('action', function($row){

                if($row->substatus == 'Submitted')
                {
                    $dropdown = '
                    <div class="dropdown">
                            <button class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                <a class="dropdown-item" 
                                data-bs-toggle="modal" data-bs-target="#Updatesub'.$row->stuID.$row->subID.'">Setting</a>
                                </li>
                                <li>
                                <a class="dropdown-item" href="'.route('subDocDown',$row->subID).'">Download</a>
                                </li>
                            </ul>
                    </div>';

                }
                else
                {
                    $dropdown = '
                    <div class="dropdown">
                            <button class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Updatesub'.$row->stuID.$row->subID.'">Setting</a></li>
                            </ul>
                    </div>';
                }
               

                return $dropdown;
            });
            $table->rawColumns(['subduedate','substatus','action']);
            return $table->make(true);

        }
        $stusubdetail =DB::table('students as a')
                            ->join('programmes as b','a.programme_id','=','b.id')
                            ->join('submissions as f','a.id','=','f.student_id')
                            ->join('documents as g','f.document_id','=','g.id')
                            ->where('a.status','=','Active')
                            ->select(
                                'a.id as stuID',
                                'a.name',
                                'a.matricNo',
                                'a.phoneNo',
                                'a.semcount',
                                'a.programme_id as progID',
                                'a.email',
                                'a.status',
                                'b.prog_code as code',
                                'b.prog_mode as mode',
                                'f.id as subID',
                                'f.submission_doc as subdoc',
                                'f.submission_date as subdate',
                                'f.submission_duedate as subduedate',
                                'f.submission_status as substatus',
                                'g.doc_name as docname'
                                )
                            ->get();
        return view('submission.submission.index',[
            'title'=>'e-Repo | Submission Management',
            'sub'=>$stusubdetail
        ]);
    }

    public function updateSubmission(Request $request , $id )
    {
        try{
            
            Submission::where('id',$id)->update(['submission_duedate'=>$request->submission_duedate,'submission_status'=>$request->submission_status]);
            return back()->with('success','Success: Submission updated successfully !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }
    public function indexSuggestion(Request $request){
        $suggest = DB::table('submissions')
                        ->join('students','submissions.student_id','=','students.id')
                        ->join('documents','submissions.document_id','=','documents.id')
                        ->join('activities','documents.activity_id','=','activities.id')
                        ->join('activity_programmes', 'students.programme_id', '=', 'activity_programmes.programmes_id')
                        ->where('activities.id','=',$request->activity_id)
                        ->where('students.status','=','Active')
                        ->select(
                                    'students.id as stuID','students.name',
                                    'students.matricNo','students.opcode','students.semcount',
                                    'activity_programmes.activities_id','activity_programmes.programmes_id as prog_id','documents.id as docID',
                                    'activities.act_name','activity_programmes.timeline_sem',
                                    'submissions.submission_status as subStatus','submissions.id as subID',
                                    'submissions.student_id','documents.isRequired'
                                )
                        ->get();
        $countNoRequiredSub = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('activities.id','=',$request->activity_id)
                        ->where('documents.isRequired','=','0')
                        ->where('submissions.submission_status','=','Submitted')
                        // ->where('submissions.student_id','=', auth()->user()->id) 
                        ->count();              
        $actId = 0;
        $display=false;
        $collection = collect([]);
        foreach($suggest as $item1)
        {
            if(($item1->semcount >= $item1->timeline_sem) && ($item1->subStatus  == 'Locked'||
            $item1->subStatus  == 'No Attempt' ||$item1->subStatus  == 'Overdue') && 
            $item1->activities_id == $request->activity_id)
            {
                $collection->push([
                    'name'=>$item1->name,
                    'id'=> $item1->stuID , 
                    'matricNo'=> $item1->matricNo ,
                    'opcode'=>$item1->opcode,
                    'semcount'=>$item1->semcount, 
                    'activities_id'=> $item1->activities_id, 
                    'progID'=> $item1->prog_id, 
                    'act_name'=> $item1->act_name, 
                    'timeline_sem'=> $item1->timeline_sem, 
                    'subID'=> $item1->subID,
                    'document_id'=> $item1->docID, 
                    'isRequired'=>$item1->isRequired,
                    'status'=> $item1->subStatus 
                ] );
                $actId = $item1->act_name;
                $display = true;

            }
        }

        $unique = $collection->unique('matricNo');
        $unique->all();


        return view("submission.suggestion.index",[
            "title" => "e-Repo | Suggestion System",
            "acts"=> Activity::all(), 
            'data' => $unique->values(),
            'actID'=> $actId,
            'display'=>$display,
            'countNo'=>$countNoRequiredSub

        ]);        
    }
 
    public function selectStudent(Request $request){

        try
        {
            foreach($request->stuid as $id)
            {
                $up = DB::table('submissions')
                    ->join('students','submissions.student_id','=','students.id')
                    ->join('documents','submissions.document_id','=','documents.id')
                    ->join('activities','documents.activity_id','=','activities.id')
                    ->join('activity_programmes', 'students.programme_id', '=', 'activity_programmes.programmes_id')
                    ->where('activities.id','=',$request->actID)
                    ->where('submissions.student_id','=',$id)
                    ->where('students.status','=','Active')
                    ->select(
                                'students.id as stuID','students.name',
                                'students.matricNo','students.email','students.opcode','students.semcount',
                                'activity_programmes.activities_id','documents.id as docID',
                                'documents.doc_name as docname',
                                'activities.act_name','activity_programmes.timeline_sem',
                                'activity_programmes.timeline_week',
                                'submissions.submission_status as subStatus','submissions.id as subID',
                                'submissions.student_id', 'submissions.submission_duedate as subDuedate'
                            )
                    ->get();
    
                    $currSem = Semester::where('status','Active')->first(); 
                    $mail = [];
                    foreach($up as $item1)
                    {
                        $days = $item1->timeline_week * 7;
                        $currdate =  Carbon::parse($currSem->startdate);
                        $subDate = $currdate->addDays($days);
                        if(($item1->semcount >= $item1->timeline_sem) && ($item1->subStatus  == 'Locked')&&$item1->activities_id == $request->actID)
                        {
                            Submission::where('id',$item1->subID)->update(['submission_status'=>'No Attempt','submission_duedate' => $subDate]);
                            $mail = [
                                'name'=>$item1->name,
                                'email'=>$item1->email,
                                'duedate'=>$subDate,
                                'docname'=>$item1->docname,
                                'actname'=>$item1->act_name
                            ];
                            Mail::to($mail['email'])->send(new SubmissionNotify($mail));
                        }
                        // elseif(($item1->semcount >= $item1->timeline_sem) && ($item1->subStatus  == 'Locked') && Carbon::parse(Carbon::now()) > Carbon::parse($item1->subDuedate)  &&$item1->activities_id == $request->actID)
                        // {
                        //     Submission::where('id',$item1->subID)->update(['submission_status'=>'Overdue']);
                        // }
                        
                    }
            }
            return back()->with('success','Success: Student submission has been assigned and email have been sent !');
        }
        catch(Exception $e)
        {
            return back()->with('error','Error: '.$e->getMessage());
        }
        
    }

    public function revertStudent($id,$act){
        $up = DB::table('submissions')
        ->join('students','submissions.student_id','=','students.id')
        ->join('documents','submissions.document_id','=','documents.id')
        ->join('activities','documents.activity_id','=','activities.id')
        ->join('activity_programmes', 'students.programme_id', '=', 'activity_programmes.programmes_id')
        ->where('activities.id','=',$act)
        ->where('submissions.student_id','=',$id)
        ->select(
                    'students.id as stuID','students.name',
                    'students.matricNo','students.opcode','students.semcount',
                    'activity_programmes.activities_id','documents.id as docID',
                    'activities.act_name','activity_programmes.timeline_sem',
                    'submissions.submission_status as subStatus','submissions.id as subID',
                    'submissions.student_id'
                )
        ->get();

        foreach($up as $item1)
        {
            if(($item1->semcount >= $item1->timeline_sem) && ($item1->subStatus  == 'No Attempt'|| $item1->subStatus  == 'Overdue' || $item1->subStatus =="Submitted") && $item1->activities_id == $act)
            {   
                Submission::where('id',$item1->subID)->update(['submission_status'=>'Locked']);
            }
                
        }
        return back()->with('success','Success: Student submission has been reverted !');
    }

    public function refreshSubmission(){
       
        try{
            $data = DB::table('activity_programmes')
            ->join('activities','activity_programmes.activities_id','=','activities.id')
            ->join('documents','activity_programmes.activities_id','=','documents.activity_id')
            ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
            ->join('students','programmes.id','=','students.programme_id')
            ->where('students.status','=','Active')
            ->select('students.id as studentsID','students.name','students.status',
            'students.opcode','students.semcount','activity_programmes.activities_id',
            'activity_programmes.timeline_sem','activity_programmes.timeline_week',
            'activity_programmes.init_status','documents.doc_name','documents.id as docID')
            ->get(); 

            // dd($data);
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
                    $collection->push([
                        'submission_doc' => '-',
                        'submission_duedate' => $subDate,
                        'submission_status' => $item->init_status ,
                        'submission_final_form'=>'-',
                        'student_id'=>$item->studentsID, 
                        'document_id'=>$item->docID ]);
                    Student::where('id',$item->studentsID)->update(['opcode'=>'0']);
                }

            } 

            Submission::insert($collection->all());
            return back()->with('success','Success: Refresh data operation success !');
        }
        catch(Exception $e){
            DB::rollback();
            return back()->with('error',$e->getMessage());

        }
    }


    public function isolatedList(){
        $isoData = DB::table('activity_programmes')
                        ->join('activities','activity_programmes.activities_id','=','activities.id')
                        ->join('documents','activity_programmes.activities_id','=','documents.activity_id')
                        ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
                        ->join('students','programmes.id','=','students.programme_id')
                        ->where('students.opcode','=','0')
                        ->where('students.status','=','Active')
                        ->select('students.id','documents.id as docID','students.name','students.matricNo','programmes.prog_code','students.opcode','students.semcount','activity_programmes.activities_id','activity_programmes.timeline_sem')
                        ->get();

        $collection = collect([]);
        foreach($isoData as $item)
        {
            if(Submission::where('student_id',$item->id)->where('document_id',$item->docID)->where('submission_status','Submitted')->exists() == false  && $item->semcount>= $item->timeline_sem)
            {
                $collection->push(['name'=>$item->name,'id'=> $item->id , 'matricNo'=> $item->matricNo ,'opcode'=>$item->opcode,'semcount'=>$item->semcount, 'prog_code'=> $item->prog_code,'activities_id'=> $item->activities_id, 'timeline_sem'=> $item->timeline_sem ] );
            }
        }
        $uniqueCollection = $collection->unique();
        $uniqueCollection->all();
        return response()->json(['data'=>$uniqueCollection->values()]);


    }

    public function studentRemoveIsolate(Request $request){
        DB::table('activity_programmes')
             ->join('activities','activity_programmes.activities_id','=','activities.id')
             ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
             ->join('students','programmes.id','=','students.programme_id')
             ->where('students.id','=', $request->id)
             ->update(['opcode'=> '1']);
 
         return back();
    }

   

    public function suggestionApproval(Request $request){
        
        $data = DB::table('activity_programmes')
                    ->join('activities','activity_programmes.activities_id','=','activities.id')
                    ->join('documents','activity_programmes.activities_id','=','documents.activity_id')
                    ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
                    ->join('students','programmes.id','=','students.programme_id')
                    ->where('activity_programmes.activities_id','=',$request->actID)
                    ->where('students.opcode','=','1')
                    ->where('students.status','=','Active')
                    ->select('students.id as studentsID','students.name','students.status','students.opcode','students.semcount','activity_programmes.activities_id','activity_programmes.timeline_sem','activity_programmes.timeline_week','documents.doc_name','documents.id as docID')
                    ->get(); 
                               
        $currSem = Semester::where('status','Active')->first(); 
       


        $collection = collect([]);
        foreach($data as $item)
        {
            if($item->semcount >= $item->timeline_sem)
            {
                $check = Submission::where('student_id',$item->studentsID)->where('document_id',$item->docID)->exists();
                if(!$check)
                {
                    $days = $item->timeline_week * 7;
                    $currdate =  Carbon::parse($currSem->startdate);
                    $subDate = $currdate->addDays($days);
                    $collection->push(['submission_doc' => '-','submission_duedate' => $subDate,'submission_status' => 'No Attempt','submission_final_form'=>'-','student_id'=>$item->studentsID, 'document_id'=>$item->docID ]);
                    Student::where('id',$item->studentsID)->update(['opcode'=>'3']);
                }
            }
                

        }
        Submission::insert($collection->all());

        // foreach($data as $item)
        // {
            
        //     if($item->semcount >= $item->timeline_sem)
        //     {
        //         $check = Submission::where('student_id',$item->studentsID)->where('document_id',$item->docID)->exists();
        //         if(!$check)
        //         {
        //             Student::where('id',$item->studentsID)->update(['opcode'=>'3']);
        //         }
        //     }

        // }
        return back()->with('success','Submission has been assigned !!');
    }

    public function AcceptedList(){
        $accData = DB::table('activity_programmes')
                    ->join('activities','activity_programmes.activities_id','=','activities.id')
                    ->join('programmes','activity_programmes.programmes_id','=','programmes.id')
                    ->join('students','programmes.id','=','students.programme_id')
                    ->where('students.opcode','=','3')
                    ->where('students.status','=','Active')
                    ->select('students.id','students.name','students.matricNo','programmes.prog_code','students.opcode','students.semcount','activity_programmes.activities_id','activity_programmes.timeline_sem')
                    ->get();
        return response()->json(['data'=>$accData]);


    }   

    public function downloadsDoc($id)
    {
        try{
            $file = Submission::where('id' , $id)->first();
            return response()->download(public_path('Submissions_file/'.$file->submission_doc));

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }


    } 

    // public function sentMail(Request $request)
    // {
    //     $data = $request->validate([
    //         'name'=>'required'
    //     ]);

    //     Mail::to('mzkstudio33@gmail.com')->send(new SubmissionNotify($data));
    //     dd('sent');
    // }
}




// public function indexSuggestion(Request $request){
//     $suggest = DB::table('submissions')
//                     ->join('students','submissions.student_id','=','students.id')
//                     ->join('documents','submissions.document_id','=','documents.id')
//                     ->join('activities','documents.activity_id','=','activities.id')
//                     ->join('activity_programmes', 'students.programme_id', '=', 'activity_programmes.programmes_id')
//                     ->where('activities.id','=',$request->activity_id)
//                     ->select(
//                                 'students.id as stuID','students.name',
//                                 'students.matricNo','students.opcode','students.semcount',
//                                 'activity_programmes.activities_id','activity_programmes.programmes_id as prog_id','documents.id as docID',
//                                 'activities.act_name','activity_programmes.timeline_sem',
//                                 'submissions.submission_status as subStatus','submissions.id as subID',
//                                 'submissions.student_id','documents.isRequired'
//                             )
//                     ->get();
//     $countNoRequiredSub = DB::table('activities')
//                     ->join('documents','activities.id','=','documents.activity_id')
//                     ->join('submissions','documents.id','=','submissions.document_id')
//                     ->where('activities.id','=',$request->activity_id)
//                     ->where('documents.isRequired','=','0')
//                     ->where('submissions.submission_status','=','Submitted')
//                     // ->where('submissions.student_id','=', auth()->user()->id) 
//                     ->count();              
//     $actId = 0;
//     $display=false;
//     $collection = collect([]);
//     foreach($suggest as $item1)
//     {
//         if(($item1->semcount >= $item1->timeline_sem) && ($item1->subStatus  == 'Locked'||$item1->subStatus  == 'No Attempt' ||$item1->subStatus  == 'Overdue') && $item1->activities_id == $request->activity_id)
//         {
//             $collection->push([
//                 'name'=>$item1->name,
//                 'id'=> $item1->stuID , 
//                 'matricNo'=> $item1->matricNo ,
//                 'opcode'=>$item1->opcode,
//                 'semcount'=>$item1->semcount, 
//                 'activities_id'=> $item1->activities_id, 
//                 'progID'=> $item1->prog_id, 
//                 'act_name'=> $item1->act_name, 
//                 'timeline_sem'=> $item1->timeline_sem, 
//                 'subID'=> $item1->subID,
//                 'document_id'=> $item1->docID, 
//                 'isRequired'=>$item1->isRequired,
//                 'status'=> $item1->subStatus 
//             ] );
//             $actId = $item1->act_name;
//             $display = true;

//         }
//     }

//     $unique = $collection->unique('matricNo');
//     $unique->all();

//     return view("submission.suggestion.index",[
//         "title" => "e-Repo | Suggestion System",
//         "acts"=> Activity::all(), 
//         'data' => $unique->values(),
//         'actID'=> $actId,
//         'display'=>$display,
//         'countNo'=>$countNoRequiredSub

//     ]);        
// }

