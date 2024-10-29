<?php

use Carbon\Carbon;
?>

@extends('student.layouts.main')


@section('content')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<style>
    .kbw-signature { width: 200px; height: 100px;}
    /* #sig canvas{
        width: 100% !important;
        height: auto;
    } */
</style>
<div class="page">
   <!-- Start::app-content -->
   <div class="main-content app-content">
       <div class="container">

           <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-bold fs-24 mb-0">Submissions List</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ Auth::user()->programme->prog_code }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('studentActivity') }}">Activity</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $taskname->act_name }}</li>
                    </ol>
            </div>
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <a href="{{ route('studentActivity') }}" class="btn btn-primary-transparent btn-sm"><i class='bx bx-arrow-back align-middle me-1'></i> Back</a>
            </div>  
           <!-- Page Header Close -->

           <!-- Start::row-1 -->
           <div class="row">
                @foreach($tasks as $task)
                <span style="display: none">{{ $id = $task->activity_id }}</span>
                    <div class="kanban-tasks" id="new-tasks">
                        <div id="new-tasks-draggable" data-view-btn="new-tasks">
                            <div class="card custom-card">
                                <div class="card-body p-0">
                                    <div class="p-3 kanban-board-head">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="task-badges">
                                                <span class="badge bg-light text-default">{{ $taskname->act_name }}</span>
                                                @if($task->submission_status == "No Attempt" || $task->submission_status == "Open" )
                                                    <span class="ms-1 badge bg-warning-transparent">{{ $task->submission_status }}</span>
                                                @elseif($task->submission_status == "Overdue")
                                                    <span class="ms-1 badge bg-danger-transparent">{{ $task->submission_status }}</span>
                                                @elseif($task->submission_status == "Not Submitted")
                                                    <span class="ms-1 badge bg-danger-transparent">{{ $task->submission_status }}</span>
                                                @else
                                                    <span class="ms-1 badge bg-success-transparent">{{ $task->submission_status }}</span>
                                                @endif
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="kanban-content mt-2">
                                            <h6 class="fw-semibold mb-1 fs-15">{{$task->doc_name}}</h6>
                                        </div>
                                    </div>
                                    <div class="p-3 border-top border-block-start-dashed">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="kanban-task-description"><strong>Due Date : </strong>{{ Carbon::parse($task->submission_duedate)->format('d M Y , h:i A')}}</div>
                                            </div>
                                            <div>
                                                @if(!$stuCheck)
                                                    @if($task->submission_status == "No Attempt" || $task->submission_status == "Open")
                                                        <a href="{{ route('documentsubmission',$task->id) }}" class="btn btn-outline-secondary btn-sm btn-wave me-0"><i class='bx bxs-add-to-queue me-1 align-middle'></i>Add Submission</a>
                                                    @elseif($task->submission_status == "Overdue")
                                                        <a href="{{ route('documentsubmission',$task->id) }}" class="btn btn-danger-transparent btn-sm btn-wave me-0"><i class='bx bxs-edit-alt me-1 align-middle'></i>Add Submission</a>
                                                    @elseif($task->submission_status == "Submitted")
                                                        <a href="{{ route('documentsubmission',$task->id) }}" class="btn btn-success-transparent btn-sm btn-wave me-0"><i class='bx bxs-edit-alt me-1 align-middle'></i>Update Submission</a>
                                                    @elseif($task->submission_status == "Not Submitted")
                                                    @else
                                                        <a href="{{ route('documentsubmission',$task->id) }}" class="btn btn-success-transparent btn-sm btn-wave me-0"><i class='bx bxs-badge-check me-1 align-middle'></i>Check Submission Status</a>
                                                    @endif
                                                @elseif( $stuCheck && $stuact->ac_status = 'Rejected')
                                                    <a href="{{ route('documentsubmission',$task->id) }}" class="btn btn-danger-transparent btn-sm btn-wave me-0"><i class='bx bxs-edit-alt me-1 align-middle'></i>Update Submission</a>
                                                @endif
                                           </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
               

                @if($openCS)
                <div class="d-flex justify-content-end">
                    <a class="modal-effect btn btn-danger-transparent btn-sm d-grid mb-3" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modaldemo8">Confirm Submission</a>
                </div>
                @endif

                <div class="modal fade"  id="modaldemo8">
                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <form action="{{ route('confirmsubmission',$id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h6 class="modal-title">Confirm Submission</h6><button type="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p class="text-dark mb-1 fw-bold">Note</p>
                                    <p class="text-muted mb-0">Please carefully review your submission before proceeding. Confirm that all required documents and information are attached.</p>
                                    <p class="text-muted mt-1">In the space provided below, please affix your digital <span class="fw-bold text-dark">signature</span> to officially confirm your submission.</p>
                                    <div class="d-flex justify-content-center">
                                        <div id="sig"></div>
                                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                                    </div>
          
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="clear" class="btn btn-danger-transparent btn-sm">Clear Signature</button>
                                    <button type="submit"  class="btn btn-success btn-sm ">Confirm</button>
                                </div>
                            </form>
                           
                        </div>
                    </div>
                </div>
           </div>
           <!--End::row-1 -->
           {{-- <a href="{{ route('test',$id) }}" class="btn btn-warning btn-sm">Test</a> --}}

       </div>
   </div>
   <!-- End::app-content -->
   <script type="text/javascript">
        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>

   @include('student.layouts.footer')

</div>
@endsection