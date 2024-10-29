<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\PanelNomination;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class NominationController extends Controller
{
    public function indexNomination(Request $request){
        if ($request->ajax()) {
          
            $data = DB::table('students as a')
                        ->join('panel_nominations as b','a.id','=','b.student_id')
                        ->join('activities as c','b.activity_id','=','c.id')
                        ->whereIn('b.nom_status', ['Pending', 'Approved'])
                        ->select('a.id as stuID','a.name','a.matricNo','b.id as nomID','b.nom_status as nomstatus','b.nom_document as nomdoc','c.act_name as actname')
                        ->get();
           
        
            $table = DataTables::of($data)->addIndexColumn();
            $table->addColumn('nomdoc', function($row){
              
                $html = '<a href="'.route('nomDown',$row->nomID).'" class="btn btn-sm btn-primary-transparent">Download</a>';
                return $html;
            });
            $table->addColumn('nomstatus', function($row){
                if($row->nomstatus == 'Pending')
                {
                    $html = '<span class="badge rounded-pill bg-warning">'.$row->nomstatus.'</span>';
                }
                elseif($row->nomstatus == 'Rejected')
                {
                    $html = '<span class="badge rounded-pill bg-danger">'.$row->nomstatus.'</span>';
                }
                else
                {
                    $html = '<span class="badge rounded-pill bg-success">'.$row->nomstatus.'</span>';
                }
                return $html;
          
            });
            $table->addColumn('action', function($row){
                if($row->nomstatus != 'Approved')
                {
                    $button = '
                    <div class="hstack gap-2 fs-15">
                        <button class="btn btn-sm btn-success-transparent" data-bs-toggle="modal"data-bs-target="#modalApprove'.$row->nomID.'">Approve</button>
                        <button class="btn btn-sm btn-danger-transparent" id="alert-confirm-reject'.$row->nomID.'">Reject</button>

                    </div>
               
                <script type="text/javascript">
                    $(document).ready(function(){
                        
                        document.getElementById("alert-confirm-reject'.$row->nomID.'").onclick = function () {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "You cannot revert this action !",
                                icon: "info",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Yes, Reject !"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="'.route('nominationRejection',$row->nomID).'";
                                    }, 1000);
                                    Swal.fire(
                                        "Rejected !",
                                        "Nomination has been rejected.",
                                        "error"
                                    )
                                }
                            })
                        }
                    });
                
                </script>
                     ';
                }
                else{
                    $button = '';
                }
               
                return $button;
            });
            $table->rawColumns(['nomdoc','nomstatus','action']);
            return $table->make(true);
        }
        $data = DB::table('students as a')
                        ->join('panel_nominations as b','a.id','=','b.student_id')
                        ->join('activities as c','b.activity_id','=','c.id')
                        ->whereIn('b.nom_status', ['Pending', 'Approved'])
                        ->select('a.id as stuID','a.name','a.matricNo','b.id as nomID','b.nom_status as nomstatus','b.nom_document as nomdoc','c.act_name as actname')
                        ->get();
        return view('staff.nomination.index',[
            'title'=>'e-Repo | Nomination Management',
            'studs'=>$data
        ]);
    }

    public function nominationApproval(Request $request ,$id)
    {
        try{
            $request->validate([
                'num_document'=>'required'
            ]);
            $details =  PanelNomination::where('id',$id)->first();
            $student = DB::table('students')
            ->where('id',$details->student_id)
            ->first();
            $acts = DB::table('activities')
                        ->where('id',$details->activity_id)
                        ->first();

            $file = $request->file('num_document');
            $filename =$student->matricNo.'_'.str_replace(' ','',$acts->act_name).'_Nomination.'. $file->getClientOriginalExtension();
            $file->move(public_path('NominationForm'),$filename);
            PanelNomination::where('id',$id)->update(['nom_status'=>'Approved']);
            return redirect()->route('evaluationArragement')->with('success','Nomination has been approved !, Please set the examiner. ');

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }

    public function nominationRejection($id)
    {
        // dd('reject',$id);
        try{
            PanelNomination::where('id',$id)->update(['nom_status'=>'Rejected']);
            return back()->with('success','Nomination has been rejected!');

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }


    public function downloadNominationForm($id)
    {
        try{
            $file = PanelNomination::where('id' , $id)->first();
            return response()->download(public_path('NominationForm/'.$file->nom_document));

        }
        catch(Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }

    
}
