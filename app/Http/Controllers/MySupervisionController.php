<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\Review;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\PanelNomination;

use App\Models\StudentActivity;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use App\Exports\MySvStudentExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class MySupervisionController extends Controller
{
    public function indexStudentList(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('semesters as c','a.semester_id','=','c.id')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','Active')
                        ->select('a.id as stuID','a.name','a.matricNo','a.phoneNo','a.semcount','a.programme_id as progID','a.email','a.status','a.titleOfResearch as title',
                                'b.prog_code as code','b.prog_mode as mode','c.label as sem','d.supervision_role as svrole')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('mode', function($row){
                if($row->mode == "PT")
                {
                    $badge = '<span class="badge rounded-pill bg-purple-transparent">Part-Time</span>';
                }
                else
                {
                    $badge = '<span class="badge rounded-pill bg-purple">Full-Time</span>';
                }
                return $badge;
            });

            $table->rawColumns(['mode']);
            return $table->make(true);
        }
        return view('staff.mysupervision.studentlist',[
            'title'=>'e-Repo | My Student  ',
        ]);
    }
    public function exportStudentList() 
    {
        return Excel::download(new MySvStudentExport, 'mysupervisionlist.xlsx');
    }

    public function indexSubmission(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->join('submissions as f','a.id','=','f.student_id')
                        ->join('documents as g','f.document_id','=','g.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','Active')
                        ->where('f.submission_status','!=','Locked')
                        ->select(
                            'a.id as stuID',
                            'a.name',
                            'a.matricNo',
                            'a.phoneNo',
                            'a.semcount',
                            'a.programme_id as progID',
                            'a.email',
                            'a.status',
                            'd.supervision_role as svrole',
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
                            <button class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Updatesub'.$row->stuID.$row->subID.'">Setting</a></li>
                                <li><a class="dropdown-item" href="'.route('subDocDown',$row->subID).'">Download</a></li>
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
        $stusubdetail = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->join('submissions as f','a.id','=','f.student_id')
                        ->join('documents as g','f.document_id','=','g.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','Active')
                        ->where('f.submission_status','!=','Locked')
                        ->select(
                            'a.id as stuID',
                            'a.name',
                            'a.matricNo',
                            'a.phoneNo',
                            'a.semcount',
                            'a.programme_id as progID',
                            'a.email',
                            'a.status',
                            'd.supervision_role as svrole',
                            'f.id as subID',
                            'f.submission_doc as subdoc',
                            'f.submission_date as subdate',
                            'f.submission_duedate as subduedate',
                            'f.submission_status as substatus',
                            'g.doc_name as docname'
                            )
                        ->get();
        return view('staff.mysupervision.studentSubmission',[
            'title'=>'e-Repo | Supervision Submission Management',
            'sub'=>$stusubdetail
        ]);
    }

    public function updateSubmission(Request $request , $id )
    {
        try{
            Submission::where('id',$id)->update(['submission_duedate'=>$request->duedate]);
            return back()->with('success','Submission updated successfully !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }

    public function indexSubmissionApproval(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('programmes as b','a.programme_id','=','b.id')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->join('student_activities as h','a.id','=','h.student_id')
                        ->join('activities as i','h.activity_id','=','i.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->whereIn('h.ac_status', ['Confirmed', 'Approved(SV)','Approved(D)'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','Active')
                        ->select(
                            'a.id as stuID',
                            'a.name',
                            'a.matricNo',
                            'a.phoneNo',
                            'a.semcount',
                            'a.programme_id as progID',
                            'a.email',
                            'a.status',
                            'd.supervision_role as svrole',
                            'e.srole as roles',
                            'h.ac_form as finaldoc',
                            'h.ac_status as finalstatus',
                            'h.ac_dateStudent as studentdate',
                            'i.id as actID',
                            'i.act_name as actname',

                            )
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('studentdate', function($row){
                $date= Carbon::parse($row->studentdate)->format('d M Y , h:i A');
                return $date;
            });
            $table->addColumn('finaldoc', function($row){
                $docdown = ' <a href="'.route('mysvfinalDocDown',['act'=>$row->actID, 'stud'=>$row->stuID]).'" class="me-0" style="color:blue;"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" style="fill: rgba(174, 22, 22, 1);transform: ;msFilter:;" class=" align-middle me-1">
                <path d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 
                1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z"></path>
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 
                0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 
                1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 
                0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v
                1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z"></path>
                </svg>'
                .$row->finaldoc.
                '</a>';
                return $docdown;
            });
            $table->addColumn('finalstatus', function($row){
                if($row->finalstatus == "Rejected" )
                {
                    $status = '<span class="badge rounded-pill bg-danger">'.$row->finalstatus.'</span>';
                }
                elseif($row->finalstatus == "Confirmed")
                {
                    $status = '<span class="badge rounded-pill bg-warning">'.$row->finalstatus.'</span>';
                }
                else
                {
                    $status = '<span class="badge rounded-pill bg-success">'.$row->finalstatus.'</span>';
                }
                return $status;

            });
            $table->addColumn('action', function($row){
                if($row->svrole == "Supervisor" && $row->finalstatus == "Confirmed")
                {
                    $button = ' <a class="modal-effect btn btn-success-transparent btn-sm d-grid my-1" 
                    data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalAccept-'.$row->actID.$row->stuID.'">Approve</a>
                                <a class="modal-effect btn btn-danger-transparent btn-sm  d-grid my-1" 
                                data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalReject-'.$row->actID.$row->stuID.'">Reject</a> ';

                }
                elseif($row->svrole == "Supervisor" && $row->finalstatus == "Approved(SV)")
                {
                    $button = '<span class=" badge rounded-pill text-muted">Approved</span>';
                }
                else
                {
                    $button = '<span class=" badge rounded-pill text-muted">No Permission</span>';
                }
                return $button;
             });
             $table->rawColumns(['studentdate','finaldoc','finalstatus','action']);
            return $table->make(true);
        }
        $studentdetail = DB::table('students as a')
                    ->join('programmes as b','a.programme_id','=','b.id')
                    ->join('student_staff as d','a.id','=','d.student_id')
                    ->join('staff as e','d.staff_id','=','e.id')
                    ->join('student_activities as h','a.id','=','h.student_id')
                    ->join('activities as i','h.activity_id','=','i.id')
                    ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                    ->where('d.staff_id','=',auth()->user()->id)
                    ->select(
                        'a.id as stuID',
                        'a.name',
                        'a.matricNo',
                        'a.phoneNo',
                        'a.semcount',
                        'a.programme_id as progID',
                        'a.email',
                        'a.status',
                        'd.supervision_role as svrole',
                        'h.id as stuactID',
                        'h.ac_form as finaldoc',
                        'h.ac_status as finalstatus',
                        'h.ac_dateStudent as studentdate',
                        'i.id as actID',
                        'i.act_name as actname',

                        )
                    ->get();
        return view('staff.mysupervision.submissionApproval',[
            'title'=>'e-Repo | Supervision Submission Approval',
            'subs'=>$studentdetail 
        ]);

    }

    public function downloadsFinalDoc($act , $stud)
    {
        try
        {
            $file = StudentActivity::where('activity_id' , $act)->where('student_id',$stud)->first();
            return response()->download(public_path('Submissions_file/'.$file->ac_form));
        }
        catch(Exception $e)
        {
            return back()->with('error','File do not exists !');
        }
        
    }

    public function approveSubmission(Request $request , $act, $stud){

        try
        {
            if($request->signed == null)
            {
                return back()->with('error','Error: Please sign in the provided area to complete the approval process !');
            }
            $stuAct = DB::table('student_activities')
            ->where('student_id',$stud)
            ->where('activity_id',$act)
            ->first();
            $template = new TemplateProcessor(public_path('StudentActivityForm/'. str_replace('.pdf','.docx', $stuAct->ac_form)));
            $template->setImageValue('sv_sign',$request->signed);
            $template ->setValue('dateSv',Carbon::parse(new DateTime)->format('d M Y'));
            $template->saveAs(public_path('StudentActivityForm/' .str_replace('.pdf','.docx', $stuAct->ac_form)));

            // Convert doc to pdf
            $domPdfPath = base_path('vendor/dompdf/dompdf');
            Settings::setPdfRendererPath($domPdfPath);
            Settings::setPdfRendererName('DomPDF'); 
            $Content = IOFactory::load(public_path('StudentActivityForm/' .str_replace('.pdf','.docx', $stuAct->ac_form))); 
            $PDFWriter = IOFactory::createWriter($Content,'PDF');
            $PDFWriter->save(public_path('StudentActivityForm/' .$stuAct->ac_form)); 

            $task = DB::table('activities')
            ->join('documents','activities.id','=','documents.activity_id')
            ->join('submissions','documents.id','=','submissions.document_id')
            ->where('activities.id','=',$act)
            ->where('submissions.student_id','=',$stud) 
            ->get();  

            $oMerger = PDFMerger::init();
            $oMerger->addPDF( public_path('StudentActivityForm/' .$stuAct->ac_form), 'all');
            foreach($task as $t)
            {
                if($t->submission_doc != "-")
                {
                    $oMerger->addPDF( public_path('Submissions_file/'.$t->submission_doc), 'all');
                }
            }


            $oMerger->merge();
            $oMerger->save(public_path('Submissions_file/'.$stuAct->ac_form));

            StudentActivity::where('student_id',$stud)->where('activity_id',$act)->update([
            'ac_status'=>'Approved(SV)',
            'ac_dateSv'=>new DateTime,
            ]);

            return back()->with('success','Success: Student submissions has been approved !');
        }
        catch(Exception $e)
        {
            return back()->with('error','Error: '.$e->getMessage());
        }
        
       

    }

    public function rejectSubmission(Request $request,$stuact,$staff)
    {
        // dd($stuact,$staff);
        try{
            $request->validate([
                'r_comment'=>'required'
            ]);
            $stuAct = DB::table('student_activities')
                        ->where('id',$stuact)
                        ->update([
                            'ac_status'=>'Rejected'
                        ]);
            $data = [
                'r_comment' => $request->r_comment,
                'r_date' =>new DateTime,
                'staff_id' => $staff,
                'stuact_id' =>$stuact,
            ];

            Review::create($data);
            return back()->with('success','Success: Student submissions has been rejected !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }
    public function indexNomination(Request $request)
    {
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->join('activity_programmes as f','a.programme_id','f.programmes_id')
                        ->join('activities as g','f.activities_id','g.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','=','Active')
                        ->where('f.is_haveEva','=','1')
                        ->select('a.id as stuID','a.name','a.matricNo','g.act_name as actname','g.id as actID')
                        ->get();
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('nomdoc', function($row){
                $nom = DB::table('students as a')
                            ->join('panel_nominations as b','a.id','=','b.student_id')
                            ->join('student_staff as d','a.id','=','d.student_id')
                            ->join('staff as e','d.staff_id','=','e.id')
                            ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                            ->where('d.staff_id','=',auth()->user()->id)
                            ->select(
                                'a.id as stuID','a.name','a.matricNo',
                                'b.id as nomID','b.activity_id','b.nom_status',
                                'b.nom_document as nomdoc'
                            )
                            ->get();
                if($nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->count() == 0)
                {
                    $html = '<span class=" badge rounded-pill text-muted">-</span>';
                }
                else
                {
                    $html = '<a href="'.route('nomDown',$nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomID).'" class="btn btn-sm btn-primary-transparent">Download</a>';
                }
                return $html;
            });
            $table->addColumn('nomstatus', function($row){
                $nom = DB::table('students as a')
                            ->join('panel_nominations as b','a.id','=','b.student_id')
                            ->join('student_staff as d','a.id','=','d.student_id')
                            ->join('staff as e','d.staff_id','=','e.id')
                            ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                            ->where('d.staff_id','=',auth()->user()->id)
                            ->select(
                                'a.id as stuID','a.name','a.matricNo',
                                'b.id as nomID','b.activity_id','b.nom_status AS nomstatus',
                                'b.nom_document as nomdoc'
                            )
                            ->get();
                if($nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->count() == 0)
                {
                    $html = '<span class="badge rounded-pill bg-danger">Nomination required</span>';
                }
                elseif($nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus == 'Pending')
                {
                    $html = '<span class="badge rounded-pill bg-warning">'.$nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus.'</span>';
                }
                elseif($nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus == 'Rejected')
                {
                    $html = '<span class="badge rounded-pill bg-danger">'.$nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus.'</span>';
                }
                else
                {
                    $html = '<span class="badge rounded-pill bg-success">'.$nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus.'</span>';
                }
                return $html;
          
            });
            $table->addColumn('action', function($row){
                $nom = DB::table('students as a')
                            ->join('panel_nominations as b','a.id','=','b.student_id')
                            ->join('student_staff as d','a.id','=','d.student_id')
                            ->join('staff as e','d.staff_id','=','e.id')
                            ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                            ->where('d.staff_id','=',auth()->user()->id)
                            ->select(
                                'a.id as stuID','a.name','a.matricNo',
                                'b.id as nomID','b.activity_id','b.nom_status AS nomstatus',
                                'b.nom_document as nomdoc'
                            )
                            ->get();
                if($nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->count() == 0)
                {
                    $button = ' <a class="modal-effect btn btn-primary-transparent btn-sm " data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalUpload-'.$row->stuID.'-'.$row->actID.'">Upload Form</a>';
                }
                elseif( $nom->where('stuID',$row->stuID)->where('activity_id',$row->actID)->first()->nomstatus == 'Rejected')
                {
                    $button = ' <a class="modal-effect btn btn-danger-transparent btn-sm" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalUpload-'.$row->stuID.'-'.$row->actID.'">Upload Again</a>';
                }
                else
                {
                    $button = '';
                }
                return $button;
            });
            $table->rawColumns(['nomdoc','nomstatus','action']);
            return $table->make(true);
        }
        $data = DB::table('students as a')
                        ->join('student_staff as d','a.id','=','d.student_id')
                        ->join('staff as e','d.staff_id','=','e.id')
                        ->join('activity_programmes as f','a.programme_id','f.programmes_id')
                        ->join('activities as g','f.activities_id','g.id')
                        ->whereIn('d.supervision_role', ['Supervisor', 'Co-Supervisor'])
                        ->where('d.staff_id','=',auth()->user()->id)
                        ->where('a.status','=','Active')
                        ->where('f.is_haveEva','=','1')
                        ->select('a.id as stuID','a.name','a.matricNo','g.act_name as actname','g.id as actID')
                        ->get();
        $form = DB::table('forms')
                    ->where('form_appearance','NOM')
                    ->where('form_isShow','1')
                    ->get();
           
        return view('staff.mysupervision.examinerNomination',[
            'title'=>'e-Repo | Supervision Nomination',
            'studs'=>$data,
            'form'=>$form
        ]);
    }

    public function UploadNominationForm(Request $request,$stud,$act)
    {
        // dd($stud,$act);

        // try{

            $request->validate([
                'num_document'=>'required'
            ]);

            if(PanelNomination::where('student_id',$stud)->where('activity_id',$act)->exists() == false)
            {
                

                $student = Student::where('id',$stud)
                                    ->first();
                $acts = DB::table('activities')
                                ->where('id',$act)
                                ->first();
                $file = $request->file('num_document');
                $filename =$student->matricNo.'_'.str_replace(' ','',$acts->act_name).'_Nomination.'. $file->getClientOriginalExtension();
                $file->move(public_path('NominationForm'),$filename);

                $data = [
                    'nom_status'=>'Pending',
                    'nom_document'=> $filename,
                    'nom_date'=> new DateTime,
                    'student_id'=>$stud,
                    'activity_id'=>$act,

                ];
                PanelNomination::create($data);
                return back()->with('success','Nomination form has successfully being uploaded !');

            }
            elseif(PanelNomination::where('student_id',$stud)->where('activity_id',$act)->first()->nom_status == 'Rejected')
            {
        
                $student = DB::table('students')
                                ->where('id',$stud)
                                ->first();
                $acts = DB::table('activities')
                                ->where('id',$act)
                                ->first();
                $file = $request->file('num_document');
                $filename =$student->matricNo.'_'.str_replace(' ','',$acts->act_name).'_Nomination.'. $file->getClientOriginalExtension();
                $file->move(public_path('NominationForm'),$filename);

                PanelNomination::where('student_id',$stud)->where('activity_id',$act)->update(
                    [
                        'nom_status'=>'Pending',
                        'nom_document'=> $filename,
                        'nom_date'=> new DateTime,
                    ]
                );
                return back()->with('success','Nomination form has successfully being uploaded again !');

            }
        
            return back()->with('error','An error occurred during upload operation . Please try again !');
           
        // }
        // catch(Exception $e)
        // {
        //     return back()->with('error',$e->getMessage());
        // }

    }

    public function downloadNominationTemplateForm($id)
    {
        try{
            $file = Form::where('id' , $id)->first();
            return response()->download(public_path('ActivityForm/'.$file->form_doc));

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }
}
