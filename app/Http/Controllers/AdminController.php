<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StudentActivity;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
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
                        ->whereIn('h.ac_status', ['Approved(SV)','Approved(A)'])
                        ->where('a.status','Active')
                        ->where('d.supervision_role','Supervisor')
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
                            'e.sname as sname',
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" style="fill: rgba(174, 22, 22, 1);transform: ;msFilter:;" class=" align-middle me-1"><path d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z"></path><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z"></path></svg>'
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
                $button= '';
                if(Auth::guard('staff')->user()->sroles == "Timbalan Dekan Pendidikan" || $row->finalstatus == "Approved(SV)")
                {
                    $button = ' <a class="modal-effect btn btn-success-transparent btn-sm d-grid my-1" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalAccept-'.$row->actID.$row->stuID.'">Approve</a>
                                <a class="modal-effect btn btn-danger-transparent btn-sm  d-grid my-1" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalReject-'.$row->actID.$row->stuID.'">Reject</a> ';
                }
                else
                {
                    $button = '<span class=" badge rounded-pill text-muted">Approved</span>';
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
        return view('staff.admin.submissionApproval',[
            'title'=>'e-Repo | Supervision Submission Approval',
            'subs'=>$studentdetail 
        ]);

    }

    public function approveSubmission(Request $request , $act, $stud){
        
        $stuAct = DB::table('student_activities')
                        ->where('student_id',$stud)
                        ->where('activity_id',$act)
                        ->first();
        $template = new TemplateProcessor(public_path('StudentActivityForm/'. str_replace('.pdf','.docx', $stuAct->ac_form)));
        $template->setImageValue('admin_sign',$request->signed);
        $template ->setValue('dateAdmin',Carbon::parse(new DateTime)->format('d M Y'));
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
            'ac_status'=>'Approved(A)',
            'ac_dateAdmin'=>new DateTime,
        ]);

        return back()->with('success','Student submissions has been approved !');

    }
}
