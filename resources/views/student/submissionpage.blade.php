<?php

use Carbon\Carbon;
?>

@extends('student.layouts.main')


@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-bold fs-24 mb-0">{{ $sub->doc_name }}</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">{{ Auth::user()->programme->prog_code }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('studentActivity') }}">Activity</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('studentEachActivity', $sub->actID) }}">{{ $sub->act_name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $sub->doc_name }} Submission</li>
                </ol>
            </div>

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <a href="{{ route('studentEachActivity', $sub->actID) }}" class="btn btn-primary-transparent btn-sm"><i
                        class='bx bx-arrow-back align-middle me-1'></i> Back</a>
            </div>
            <!-- Page Header Close -->
            <div class="container">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card custom-card">
                            <!-- Card Status Submission -->
                            <div id="subStatus">
                                <div class="card-header">
                                    <div class="card-title">Submission Status</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table text-nowrap table-striped table-hover table-bordered border-primary">
                                            <tbody>
                                                <!-- Status Condition -->
                                                @if ($sub->submission_status == 'No Attempt' || $sub->submission_status == 'Open')
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold ">Submission Status</th>
                                                        <td class=" bg-warning-transparent">No Attempt</td>
                                                    </tr>

                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Submission Due Date</th>
                                                        <td>{{ $date = Carbon::parse($sub->submission_duedate)->format('d M Y , h:i A') }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Time Remaining</th>
                                                        <td>
                                                            {{ $days = Carbon::parse(new DateTime('now'))->diffInDays(Carbon::parse($date)) }}
                                                            days
                                                            {{ $hours = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->diffInHours(Carbon::parse($date)) }}
                                                            hours
                                                            {{ $minutes = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->addHours($hours)->diffInMinutes(Carbon::parse($date)) }}
                                                            minutes
                                                        </td>
                                                    </tr>
                                                @elseif($sub->submission_status == 'Overdue')
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Submission Status</th>
                                                        <td class=" bg-danger-transparent">{{ $sub->submission_status }}
                                                        </td>
                                                    </tr>

                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Submission Due Date</th>
                                                        <td>{{ $date = Carbon::parse($sub->submission_duedate)->format('d M Y , h:i A') }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Overdue by</th>
                                                        <td class=" bg-danger-transparent">
                                                            {{ $days = Carbon::parse(Carbon::parse($date))->diffInDays(new DateTime('now')) }}
                                                            days
                                                            {{ $hours = Carbon::parse(Carbon::parse($date))->copy()->addDays($days)->diffInHours(new DateTime('now')) }}
                                                            hours
                                                            {{ $minutes = Carbon::parse(Carbon::parse($date))->copy()->addDays($days)->addHours($hours)->diffInMinutes(new DateTime('now')) }}
                                                            minutes
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Submission Status</th>
                                                        <td class=" bg-success-transparent">{{ $sub->submission_status }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <!-- End Status Condition -->

                                                <!-- Submission date (Submitted > Above) Condition -->
                                                @if ($sub->submission_date !== null)
                                                    <tr style="height:80px">
                                                        <th scope="row" class="fw-bold">Submission Date</th>
                                                        <td class=" bg-success-transparent">
                                                            {{ Carbon::parse($sub->submission_date)->format('d M Y , h:i A') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <!-- End Submission date  Condition -->

                                                <tr style="height:80px">
                                                    <th scope="row" class="fw-bold">File Submission</th>
                                                    <td>
                                                        @if ($sub->submission_doc == '-')
                                                            {{ $sub->submission_doc }}
                                                        @else
                                                            <a href="{{ route('submissionDown', $sub->subID) }}"
                                                                class="me-0"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24" class="me-1 align-middle"
                                                                    viewBox="0 0 24 24"
                                                                    style="fill: rgba(218, 19, 19, 1);transform: ;msFilter:;">
                                                                    <path
                                                                        d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z">
                                                                    </path>
                                                                    <path
                                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z">
                                                                    </path>
                                                                </svg>{{ $sub->submission_doc }}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if ($sub->submission_status == 'Submitted')
                                        <button type="button" class="btn btn-primary btn-sm" id="addbtn">Edit
                                            Submission</button>
                                        <button class="btn btn-danger btn-sm" id="alert-confirm">Remove Submission</button>
                                        <form action="{{ route('removeSubmission', $sub->subID) }}" id="removeForm">
                                            @csrf
                                        </form>
                                    @elseif(
                                        $sub->submission_status == 'No Attempt' ||
                                            $sub->submission_status == 'Overdue' ||
                                            $sub->submission_status == 'Open')
                                        <button class="btn btn-primary btn-sm" id="addbtn">Add Submission</button>
                                    @endif

                                </div>
                            </div>
                            <!-- End Card Status Submission  -->


                            <!-- Card Submission -->
                            <div id="addSub" style="display: none">
                                <div class="card-header">
                                    <div class="card-title">Submission Area</div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('submissionPost', ['id' => $sub->subID, 'act' => $sub->actID]) }}"
                                        method="POST" class="dropzone" id="file-upload" enctype="multipart/form-data">
                                        @csrf
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="button" id="submit" class="btn btn-primary btn-sm">Save
                                        Changes</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="closeSub">Cancel</button>

                                </div>
                            </div>

                            <!-- End Card Submission -->




                        </div>
                    </div>

                </div>



            </div>


        </div>
    </div>
    <!-- End::app-content -->
    <script>
        $(document).ready(function() {

            $('#addbtn').on('click', function() {
                $("#addSub").fadeIn();
                $('#subStatus').attr('style', 'display:none');

            });
            $('#closeSub').on('click', function() {
                $('#addSub').attr('style', 'display:none');
                $("#subStatus").fadeIn();
                $('.btn-close').click();
            });
            var myDropzone = new Dropzone("#file-upload", {
                autoProcessQueue: false,
                thumbnailWidth: 100,
                dictDefaultMessage: 'Upload your files here',
                acceptedFiles: ".pdf,.docs,.txt",
                addRemoveLinks: true,
                maxFiles: 1,
                parallelUploads: 1,
                init: function() {
                    myDropzone = this;
                    document.querySelector("#submit").addEventListener('click', function(e) {
                        if (myDropzone.getQueuedFiles().length > 0) {
                            myDropzone.processQueue();
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            $(".alert").fadeIn();
                            $(".row").before(
                                '<div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert"> <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>Error: Please upload a file to continue your submission ! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button></div>'
                                );

                            setTimeout(function() {
                                $(".alert").fadeOut();
                            }, 2000);

                        }

                    });


                }

            });

            // $('#removeSub').on('click', function(){ 
            //     alert("dah tekang benggong")
            //     // $('#file-success').submit();
            // });

            document.getElementById('alert-confirm').onclick = function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Your submission will be removed completely!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setTimeout(function() {
                            $('#removeForm').submit();
                        }, 1000);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }

        });
    </script>


    @include('student.layouts.footer')

    </div>
@endsection
