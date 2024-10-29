<?php

use App\Models\Submission;
use App\Models\Programme;
?>

@extends('staff.layouts.main')


@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Suggestion System</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('suggestionSystem') }}">Submission</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Suggestion System</li>
                    </ol>
                </div>
                <!-- Page Header Close -->

                <!-- Alert Section -->
                @if (session()->has('success'))
                    <div class="alert alert-secondary alert-dismissible fade show custom-alert-icon shadow-sm"
                        role="alert">
                        <svg class="svg-secondary" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24"
                            width="1.5rem" fill="#000000">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                class="bi bi-x"></i></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                        <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24"
                            width="1.5rem" fill="#000000">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                        </svg>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                class="bi bi-x"></i></button>
                    </div>
                @endif
                <!-- End Alert Section -->
                <div class="row">

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <p class="fs-12 fw-bold text-danger">Note</p>
                                <p class="lead fs-12 fw-semibold">
                                    Please select the activity for the system automaticly shows the eligable student to get
                                    the
                                    submission. Tick on the checkbox below to select OR deselect the student.
                                </p>
                                <form action="{{ route('suggestList') }}" method="POST" id="suggestedForm">
                                    @csrf
                                    <div class="row ">
                                        <div class="col-sm-12 col-md-4">
                                            <select
                                                class=" form-select @error('activity_id') is-invalid  @enderror bg-light"
                                                name="activity_id" id="activity">
                                                @if ($actID == 0)
                                                    <option selected disabled class="fs-14">Select Activity</option>
                                                @else
                                                    <option selected disabled class="fs-14">{{ $actID }}</option>
                                                @endif
                                                @foreach ($acts as $act)
                                                    @if ($actID != $act->act_name)
                                                        <option option class="fs-14" value="{{ $act->id }}">
                                                            {{ $act->act_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('activity_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-2 d-flex justify-content-start align-items-center mt-sm-3 mt-md-0">
                                            <button type="submit" id="suggestBtn"
                                                class="btn btn-primary-transparent btn-sm"><i
                                                    class='bx bxs-magic-wand me-1'></i>Suggest</button>
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                @if ($display)
                    <div class="row" id="tableList">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <form action="{{ route('selectProcessPost') }}" method="POST" id="checkform">
                                    @csrf
                                    <div class="card-body">
                                        <!-- Table Start -->
                                        <span style="display: none">{{ $numIt = 0 }}</span>
                                        <div class="table-responsive">
                                            <table class="table text-nowrap table-bordered border-primary table-hover datas-tables">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input class="form-check-input check-all" type="checkbox"
                                                                id="checkAll" value="" aria-label="...">
                                                        </th>

                                                        <th scope="col">Name</th>
                                                        <th scope="col">Matric No.</th>
                                                        <th scope="col">Programme</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Setting</th>


                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($data as $stu)
                                                        <input type="hidden" name="actID"
                                                            value="{{ $stu['activities_id'] }}">
                                                        @if (Submission::where('student_id', $stu['id'])->where('submission_status', 'No Attempt')->count() == 0 &&
                                                                Submission::where('student_id', $stu['id'])->where('submission_status', 'Overdue')->count() == 0)
                                                            <tr class="task-list">
                                                                <td class="task-checkbox"><input class="form-check-input"
                                                                        type="checkbox" value="{{ $stu['subID'] }}"
                                                                        id="{{ $loop->iteration }}"></td>
                                                                <td>{{ $stu['name'] }}</td>
                                                                <td>{{ $stu['matricNo'] }}</td>
                                                                <td>{{ Programme::where('id', $stu['progID'])->first()->prog_code . ' (' . Programme::where('id', $stu['progID'])->first()->prog_mode . ') ' }}
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-danger">{{ $stu['status'] }}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <i class="ti ti-dots-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            {{-- <li><a class="dropdown-item" href="{{ route('revertStudent',['id'=>$stu['id'] , 'act'=> $stu['activities_id'] ]) }}">Revert Change</a></li> --}}
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                                <input type="hidden" value="{{ $stu['id'] }}"
                                                                    id="t{{ $loop->iteration }}">
                                                            </tr>
                                                        @elseif($stu['status'] == 'No Attempt' || $stu['status'] == 'Overdue')
                                                            <tr class="task-list">
                                                                <td class="task-checkbox"></td>
                                                                <td>{{ $stu['name'] }}</td>
                                                                <td>{{ $stu['matricNo'] }}</td>
                                                                <td>{{ Programme::where('id', $stu['progID'])->first()->prog_code . ' (' . Programme::where('id', $stu['progID'])->first()->prog_mode . ') ' }}
                                                                </td>
                                                                <td><span
                                                                        class="badge bg-warning-transparent">{{ $stu['status'] }}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <i class="ti ti-dots-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a class="dropdown-item"
                                                                                    href="{{ route('revertStudent', ['id' => $stu['id'], 'act' => $stu['activities_id']]) }}">Revert
                                                                                    Change</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr class="task-list">
                                                                <td class="task-checkbox"></td>
                                                                <td>{{ $stu['name'] }}</td>
                                                                <td>{{ $stu['matricNo'] }}</td>
                                                                <td>{{ Programme::where('id', $stu['progID'])->first()->prog_code . ' (' . Programme::where('id', $stu['progID'])->first()->prog_mode . ') ' }}
                                                                </td>
                                                                <td><span
                                                                        class="badge bg-danger-transparent">Restricted</span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="btn btn-icon btn-sm btn-light btn-wave waves-light waves-effect"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <i class="ti ti-dots-vertical"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            {{-- <li><a class="dropdown-item" href="{{ route('revertStudent',['id'=>$stu['id'] , 'act'=> $stu['activities_id'] ]) }}">Revert Change</a></li> --}}
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <span style="display: none">{{ $numIt = $loop->iteration }}</span>
                                                        <input type="hidden" id="num2{{ $loop->iteration }}"
                                                            name="stuid[]">
                                                    @endforeach
                                                    <input type="hidden" value="{{ $numIt }}" id="num">

                                                </tbody>

                                            </table>
                                        </div>
                                        <!-- End Table  -->
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        @include('staff.layouts.footer')
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            //AJAX CODE SEGMENT - SUGGESTION
            $(document).ready(function() {
                
                var num = parseInt($('#num').val());

                for (let i = 0; i <= num; i++) {

                    $('#' + i).on('click', function(e) {
                        var checked = $('#' + i).is(':checked');
                        if (checked) {
                            $('#num2' + i).val($('#t' + i).val());
                        } else {
                            $('#num2' + i).val('');
                        }

                    });

                    $('#checkAll').click(function(event) {
                        if (this.checked) {
                            // Iterate each checkbox
                            $(':checkbox').each(function() {
                                this.checked = true;
                                $('#num2' + i).val($('#t' + i).val());

                            });
                        } else {
                            $(':checkbox').each(function() {
                                this.checked = false;
                                $('#num2' + i).val('');

                            });
                        }
                    });
                }
                let table = new DataTable('.data-tables');




            });
        </script>
    </div>
@endsection
