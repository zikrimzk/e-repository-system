<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\Staff;
use App\Models\Review;
use App\Models\Student;
use setasign\Fpdi\Fpdi;
use App\Models\Activity;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\StudentActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
// use JorrenH\LaravelPDFMerger\PDFMerger as PDFMerger;
use App\Models\ActivityProgramme;
use App\Mail\ResetPasswordStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmSubmissionNotify;
use PhpOffice\PhpWord\TemplateProcessor;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class StudentManagementController extends Controller
{
    public function index()
    {
        $mycourse = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('submissions.student_id','=', auth()->user()->id)
                        ->get();  
        $mysv =DB::table('student_staff')
                ->join('staff','student_staff.staff_id','=','staff.id')
                ->where('student_id','=', auth()->user()->id)
                ->select('staff.sname','student_staff.supervision_role as svrole')
                ->get();
        $data2=[];
        foreach($mycourse->groupBy('activity_id') as $myc)
        {
            foreach($myc as $m)
            {
                $data2[]=$m;
            }
        }
       
    

        return view('student.dashboard',[
            'title'=> 'e-Repo | Student Dashboard ',
            'myc'=>$data2,
            'mys'=>$mysv
        ]);
    }

    public function indexActivity()
    {
        $mycourse = DB::table('students')
                        ->join('programmes','students.programme_id','=','programmes.id')
                        ->join('activity_programmes','programmes.id','=','activity_programmes.programmes_id')
                        ->join('activities','activity_programmes.activities_id','=','activities.id')
                        ->where('matricNo','=', auth()->user()->matricNo)  
                        ->orderby('act_seq','asc')
                        ->get();

                        
                        // dd($mycourse);
        $mytask = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('submissions.student_id','=', auth()->user()->id)
                        ->where('submissions.submission_status','!=', 'Locked')
                        ->get();  
                    
        $mysv = DB::table('student_staff')
                    ->join('staff','student_staff.staff_id','=','staff.id')
                    ->where('student_id','=', auth()->user()->id)
                    ->where('supervision_role','=', 'Supervisor')
                    ->select('staff.sname')
                    ->first();
        $mysvCheck = DB::table('student_staff')
                    ->join('staff','student_staff.staff_id','=','staff.id')
                    ->where('student_id','=', auth()->user()->id)
                    ->select('staff.sname')
                    ->exists();
        $stuAct = StudentActivity::where('student_id',auth()->user()->id)->get();   
        $review = Review::latest()->get();
        

 
        return view('student.activity',[
            'title'=> 'e-Repo | Course Activity',
            'acts'=>$mycourse,
            'sv'=> $mysv,
            'check'=> $mysvCheck,
            'task'=> $mytask,
            'sa'=>$stuAct,
            'rv'=>$review 
        ]);
    }

    public function indexEachActivity($id)
    {
        $taskname = DB::table('activities')
                        ->where('id','=',$id)
                        ->first();     
        $task = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('activities.id','=',$id)
                        ->where('submissions.student_id','=', auth()->user()->id) 
                        ->get();  
        $countSub = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('activities.id','=',$id)
                        // ->where('documents.isRequired','=','1')
                        ->where('submissions.student_id','=', auth()->user()->id) 
                        ->count();
        $countNoRequiredSub = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('activities.id','=',$id)
                        ->where('documents.isRequired','=','0')
                        ->where('submissions.submission_status','=','Submitted') 
                        ->where('submissions.student_id','=', auth()->user()->id) 
                        ->count();
        $countSubmit = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->where('activities.id','=',$id)
                        ->where('submissions.student_id','=', auth()->user()->id) 
                        ->where('submissions.submission_status','=','Submitted') 
                        ->count();
        $formExist = Form::where('activity_id',$id)->where('form_appearance','AS')->where('form_isShow',1)->exists();
        $stuActCheck = StudentActivity::where('student_id',auth()->user()->id)->where('activity_id',$id)->exists();
        $stuAct = StudentActivity::where('student_id',auth()->user()->id)->where('activity_id',$id)->first();            
        $openButton = false;

        // dd($countSubmit); 
        if(($countSub == $countSubmit && $formExist && !$stuActCheck) || ($countNoRequiredSub >=1 && $formExist && !$stuActCheck ) || ( $stuActCheck && $stuAct->ac_status == 'Rejected') )
        {
            $openButton = true;
        }                                        
        return view('student.eachactivity',[
            'title'=> 'e-Repo | ' . $taskname->act_name,
            'taskname'=> $taskname,
            'tasks'=>$task,
            'openCS'=>$openButton,
            'stuact'=>$stuAct,
            'stuCheck'=>$stuActCheck
        
        ]);
    }

    public function downloadsMaterial($act , $prog)
    {
        try
        {
            $file = ActivityProgramme::where('activities_id' , $act)->where('programmes_id',$prog)->first();
            return response()->download(public_path('material/'.$file->meterial));
        }
        catch(Exception $e)
        {
            return back()->with('error','File do not exists !');
        }
        
    }

   

    public function indexDocument($id)
    {
        $submission = DB::table('activities')
                            ->join('documents','activities.id','=','documents.activity_id')
                            ->join('submissions','documents.id','=','submissions.document_id')
                            ->where('submissions.id','=',$id)
                            ->where('submissions.student_id','=', auth()->user()->id) 
                            ->select('submissions.id as subID','submissions.submission_status','submissions.submission_duedate','submissions.submission_date','submissions.submission_doc','activities.id as actID','activities.act_name','documents.id as docID','documents.doc_name' )
                            ->first(); 
        return view('student.submissionpage',[
            'title'=>'e-Repo | '.$submission->doc_name.' submission',
            'sub'=>$submission
        ]);
    }

    public function submission(Request $request,$id,$act)
    {
        $detail = DB::table('activities')
                        ->join('documents','activities.id','=','documents.activity_id')
                        ->join('submissions','documents.id','=','submissions.document_id')
                        ->join('students','submissions.student_id','=','students.id')
                        ->where('submissions.id','=',$id)
                        ->where('submissions.student_id','=', auth()->user()->id) 
                        ->first();
        
        $fileAct = DB::table('activities')
                            ->join('documents','activities.id','=','documents.activity_id')
                            ->where('activities.id','=',$act)
                            ->count();

    
        $file = $request->file('file');
        $filename = $detail->matricNo.'_'.str_replace(' ', '', str_replace('/', '', $detail->doc_name)).'_'.str_replace(' ', '', $detail->act_name).'.'. $file->getClientOriginalExtension();
        $file->move(public_path('Submissions_file'),$filename);
        Submission::where('id',$id)->update(['submission_doc'=> $filename, 'submission_status'=>'Submitted','submission_date'=>new DateTime]);
        Student::where('id',auth()->user()->id)->update(['opcode'=>'1']);
        return response()->json(['success'=>$filename]);
    }

    public function removeSubmission($id)
    {
        $data = Submission::where('id',$id)->first();
        $checkOpen = DB::table('submissions as a')
                            ->join('documents as b','a.document_id','=','b.id')
                            ->join('activities as c','b.activity_id','=','c.id')
                            ->join('activity_programmes as d','c.id','=','d.activities_id')
                            ->where('a.document_id','=',$data->document_id)
                            ->where('a.id','=',$data->id)
                            ->where('d.init_status','=','Open')
                            ->exists();
        if($checkOpen)
        {
            Submission::where('id',$id)->update(['submission_doc'=>'-', 'submission_date'=>null , 'submission_status'=>'Open']);
        }
        elseif(Carbon::parse(Carbon::now()) > Carbon::parse($data->submission_duedate))
        {
            Submission::where('id',$id)->update(['submission_doc'=>'-', 'submission_date'=>null , 'submission_status'=>'Overdue']);
        }
        else
        {
            Submission::where('id',$id)->update(['submission_doc'=>'-', 'submission_date'=>null , 'submission_status'=>'No Attempt']);
        }
        return back()->with('success','Success: The submission has been removed !');

    }

    public function downloadSubmission($id)
    {
        try
        {
            $file = Submission::where('id',$id)->first();
            return response()->download(public_path('Submissions_file/'.$file->submission_doc));
        }
        catch(Exception $e)
        {
            return back()->with('error','File do not exists !');
        }
        

    }

    public function confirmSubmission(Request $request , $act)
    {
        // try
        // {
            $check= DB::table('student_activities as a')
                        ->where('a.student_id',auth()->user()->id )
                        ->where('a.activity_id',$act)
                        ->exists();
            if(!$check)
            {
                $svdetails = DB::table('student_staff as a')
                                    ->join('students as b','a.student_id','=','b.id')
                                    ->join('staff as c','a.staff_id','=','c.id')
                                    ->where('b.id','=',auth()->user()->id)
                                    ->get();
            
                $documents = DB::table('documents as a')
                                    ->join('submissions as b','a.id','=','b.document_id')
                                    ->where('a.isShowDoc','=','1')
                                    ->where('a.activity_id','=',$act)
                                    ->where('b.student_id','=',auth()->user()->id)
                                    ->get();
                // dd($documents);
                //Word assign value 
                $form = Form::where('activity_id',$act)->where('form_appearance','AS')->first();
                $template = new TemplateProcessor(public_path('ActivityForm/'. $form->form_doc));
                $template ->setValue('sname',auth()->user()->name);
                $template ->setValue('smatricNo',auth()->user()->matricNo);
                $template ->setValue('pcode',auth()->user()->programme->prog_code);
                $template ->setValue('pmode',auth()->user()->programme->prog_mode);
                if($svdetails->where('supervision_role','Supervisor')->count() >=1)
                {
                    $template ->setValue('svname',$svdetails->where('supervision_role','Supervisor')->first()->sname);
                }
                if($svdetails->where('supervision_role','Co-Supervisor')->count() >=1)
                {
                    $template ->setValue('csvname',$svdetails->where('supervision_role','Co-Supervisor')->first()->sname);
                }
                foreach($documents as $d)
                {
                    $template ->setValue('journal_name',$d->submission_doc);
                }
                $template ->setValue('titleResearch',auth()->user()->titleOfResearch);
                $template ->setValue('dateStudent',Carbon::parse(new DateTime)->format('d M Y'));
                $template->setImageValue('student_sign',$request->signed);
            

                $acts = Activity::where('id',$act)->first();
                $filename = auth()->user()->matricNo .'_'.str_replace(' ','_', $acts->act_name);
                $template->saveAs(public_path('StudentActivityForm/' .$filename. '.docx'));

                // Convert doc to pdf
                $domPdfPath = base_path('vendor/dompdf/dompdf');
                Settings::setPdfRendererPath($domPdfPath);
                Settings::setPdfRendererName('DomPDF'); 
                $Content = IOFactory::load(public_path('StudentActivityForm/' .$filename. '.docx')); 
                $PDFWriter = IOFactory::createWriter($Content,'PDF');
                $PDFWriter->save(public_path('StudentActivityForm/' .$filename. '.pdf')); 


                $task = DB::table('activities')
                            ->join('documents','activities.id','=','documents.activity_id')
                            ->join('submissions','documents.id','=','submissions.document_id')
                            ->where('activities.id','=',$act)
                            ->where('submissions.student_id','=', auth()->user()->id) 
                            ->get();  
                $oMerger = PDFMerger::init();
                $oMerger->addPDF( public_path('StudentActivityForm/' .$filename. '.pdf'), 'all');
                foreach($task as $t)
                {
                    if($t->submission_doc != "-")
                    {
                        $oMerger->addPDF( public_path('Submissions_file/'.$t->submission_doc), 'all');
                    }
                }

                
                $oMerger->merge();
                $oMerger->save(public_path('Submissions_file/'.auth()->user()->matricNo.'_'.str_replace(' ','_', $acts->act_name).'.pdf'));

                //insert into databases
                $data = [
                    'student_id'=> auth()->user()->id,
                    'activity_id'=> $act,
                    'ac_status'=> "Confirmed",
                    'ac_form'=> auth()->user()->matricNo.'_'.str_replace(' ','_', $acts->act_name).'.pdf',
                    'ac_dateStudent'=> new DateTime,
                ];
                StudentActivity::insert($data);



                $taskNotSubmiited = DB::table('activities as a')
                                ->join('documents as b','a.id','=','b.activity_id')
                                ->join('submissions as c','b.id','=','c.document_id')
                                ->where('a.id','=',$act)
                                ->where('c.student_id','=', auth()->user()->id) 
                                ->select('c.id as subID', 'c.submission_status')
                                ->get();  

                foreach($taskNotSubmiited as $tns)
                {
                    if($tns->submission_status == "No Attempt" || $tns->submission_status == "Overdue" )
                    {
                        Submission::where('id',$tns->subID)->update(['submission_status'=>'Not Submitted']);
                    }
                }
                $data = [
                    'student_id'=> auth()->user()->id,
                    'activity_id'=> $act,
                    'ac_status'=> "Confirmed",
                    'ac_form'=> auth()->user()->matricNo.'_'.str_replace(' ','_', $acts->act_name).'.pdf',
                    'ac_dateStudent'=> new DateTime,
                ];
                $staff = Staff::where('id',$svdetails->where('supervision_role','Supervisor')->first()->staff_id)->first()->email;
                Mail::to($staff)->send(new ConfirmSubmissionNotify($data));

                return redirect()->route('studentActivity')->with('success',$acts->act_name.' activity submissions has been confirmed !');
            }
            else
            {
                $stuActID= DB::table('student_activities as a')
                        ->where('a.student_id',auth()->user()->id )
                        ->where('a.activity_id',$act)
                        ->first()->id;
                $svdetails = DB::table('student_staff as a')
                                    ->join('students as b','a.student_id','=','b.id')
                                    ->join('staff as c','a.staff_id','=','c.id')
                                    ->where('b.id','=',auth()->user()->id)
                                    ->get();
                $documents = DB::table('documents as a')
                                    ->join('submissions as b','a.id','=','b.document_id')
                                    ->where('a.isShowDoc','=','1')
                                    ->where('a.activity_id','=',$act)
                                    ->where('b.student_id','=',auth()->user()->id)
                                    ->get();
                // dd($documents);
                //Word assign value 
                $form = Form::where('activity_id',$act)->where('form_appearance','AS')->first();
                $template = new TemplateProcessor(public_path('ActivityForm/'. $form->form_doc));
                $template ->setValue('sname',auth()->user()->name);
                $template ->setValue('smatricNo',auth()->user()->matricNo);
                $template ->setValue('pcode',auth()->user()->programme->prog_code);
                $template ->setValue('pmode',auth()->user()->programme->prog_mode);
                if($svdetails->where('supervision_role','Supervisor')->count() >=1)
                {
                    $template ->setValue('svname',$svdetails->where('supervision_role','Supervisor')->first()->sname);
                }
                if($svdetails->where('supervision_role','Co-Supervisor')->count() >=1)
                {
                    $template ->setValue('csvname',$svdetails->where('supervision_role','Co-Supervisor')->first()->sname);
                }
                foreach($documents as $d)
                {
                    $template ->setValue('journal_name',$d->submission_doc);
                }
                $template ->setValue('titleResearch',auth()->user()->titleOfResearch);
                $template ->setValue('dateStudent',Carbon::parse(new DateTime)->format('d M Y'));
                $template->setImageValue('student_sign',$request->signed);
            

                $acts = Activity::where('id',$act)->first();
                $filename = auth()->user()->matricNo .'_'.str_replace(' ','_', $acts->act_name);
                $template->saveAs(public_path('StudentActivityForm/' .$filename. '.docx'));

                // Convert doc to pdf
                $domPdfPath = base_path('vendor/dompdf/dompdf');
                Settings::setPdfRendererPath($domPdfPath);
                Settings::setPdfRendererName('DomPDF'); 
                $Content = IOFactory::load(public_path('StudentActivityForm/' .$filename. '.docx')); 
                $PDFWriter = IOFactory::createWriter($Content,'PDF');
                $PDFWriter->save(public_path('StudentActivityForm/' .$filename. '.pdf')); 


                $task = DB::table('activities')
                            ->join('documents','activities.id','=','documents.activity_id')
                            ->join('submissions','documents.id','=','submissions.document_id')
                            ->where('activities.id','=',$act)
                            ->where('submissions.student_id','=', auth()->user()->id) 
                            ->get();  
                $oMerger = PDFMerger::init();
                $oMerger->addPDF( public_path('StudentActivityForm/' .$filename. '.pdf'), 'all');
                foreach($task as $t)
                {
                    if($t->submission_doc != "-")
                    {
                        $oMerger->addPDF( public_path('Submissions_file/'.$t->submission_doc), 'all');
                    }
                }

                
                $oMerger->merge();
                $oMerger->save(public_path('Submissions_file/'.auth()->user()->matricNo.'_'.str_replace(' ','_', $acts->act_name).'.pdf'));

                //insert into databases
                $data = [
                    'student_id'=> auth()->user()->id,
                    'activity_id'=> $act,
                    'ac_status'=> "Confirmed",
                    'ac_form'=> auth()->user()->matricNo.'_'.str_replace(' ','_', $acts->act_name).'.pdf',
                    'ac_dateStudent'=> new DateTime,
                ];
                StudentActivity::where('id',$stuActID)->update($data);
                
                $staff = Staff::where('id',$svdetails->where('supervision_role','Supervisor')->first()->staff_id)->first()->email;
                Mail::to($staff)->send(new ConfirmSubmissionNotify($data));
                return redirect()->route('studentActivity')->with('success',$acts->act_name.' activity submissions has been re-submitted again successfully.');
            }
        // }
        // catch(Exception $e)
        // {
        //     return redirect()->route('studentActivity')->with('error',$e->getMessage());

        // }
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
    public function indexProfile()
    {
        return view('student.studentprofile',[
            'title'=> 'e-Repo | Profile '
        ]); 
    }

    public function indexEditProfile()
    {
        return view('student.studentEditprofile',[
            'title'=> 'e-Repo | Profile Update'
        ]); 
    }
    public function updateProfile(Request $request, $id)
    {
        try{
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phoneNo' => 'required',
                'address' => '',
                'bio' => '',

    
            ]);
    
            Student::where('id', $id)->update($validated);
            return back()->with('success','Profile has been updated successfully !');

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
    }

    public function updatePassword(Request $request,$id)
    {
        try{
            
            $validated = $request->validate([
                'oldPass' => 'required | min:8',
                'newPass' => 'required | min:8',
                'renewPass' => 'required | same:newPass',
            ]);
            $check = Hash::check($validated['oldPass'], Auth::guard('web')->user()->password, []);
            if($check)
            {
                Student::where('id', $id)->update(['password'=> bcrypt($validated['renewPass'])]);
                return back()->with('success','Password has been changed successfully !');
            }
            else{
                return back()->with('error','Please enter the correct password !');
            }

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }
       
       
    }
    public function indexResetPasswordRequest()
    {
       return view('student.resetpasswordrequest',[
            'title'=>'e-Repo | Reset Password Request'
       ]);
    }
    public function indexResetPassword($id)
    {
        $data = Student::where('id',$id)->first();
       return view('student.resetpassword',[
            'title'=>'e-Repo | Reset Password',
            'data'=>$data

       ]);
    }


    public function resetPasswordMail(Request $request)
    {
        $data = $request->validate([
            'email'=>'required'
        ]);

        $check = Student::where('email',$data['email'])->exists();
        if($check)
        {
            $data= Student::where('email',$data['email'])->first();
            Mail::to($data['email'])->send(new ResetPasswordStudent($data));
            return back()->with('success','We have sent the reset link in the email registered. Please check your email !');
        }
        else
        {
            return back()->with('error','The email entered are not registered , Please contact committee for futher details , Thank you !');
        }

       
    }
    public function resetPassword(Request $request,$id)
    {
        try{
            
            $validated = $request->validate([
                'password' => 'required | min:8',
                'repassword' => 'required | same:password',
            ]);
           
            Student::where('id', $id)->update(['password'=> bcrypt($validated['repassword'])]);
            return redirect()->route('student.login')->with('success','Password has been changed successfully !');
        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

       
    }
    
}
