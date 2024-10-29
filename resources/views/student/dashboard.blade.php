<?php

use Carbon\Carbon;
?>
@extends('student.layouts.main')


@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <div class="row">
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <div>
                            <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()->name }} !</p>
                            <span class="fw-semibold text-muted fs-14">Dashboard</span>
                        </div>
                    </div>
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb bg-white p-4 rounded shadow-sm">
                        <div>
                            <span class="d-block text-muted fs-12">Title of Research</span>
                            <div class="d-flex align-items-center">
                                <span class="d-block fs-14 fw-semibold">{{ auth()->user()->titleOfResearch }}</span>
                            </div>
                        </div>
                        @foreach($mys as $ms)
                            <div>
                                <span class="d-block text-muted fs-12">{{ $ms->svrole }} By</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-block fs-14 fw-semibold">{{ $ms->sname }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="row">
                        <h1 class="text-dark fw-semibold fs-18 text-center">Activity Timeline & Progress</h1>
                        <ul class="timeline list-unstyled">
                            @foreach ($myc as $m)
                                <li>
                                    <div class="timeline-time text-end">
                                        <span
                                            class="date">{{ Carbon::parse($m->submission_duedate)->format('d M Y') }}</span>
                                        <span
                                            class="time d-inline-block">{{ Carbon::parse($m->submission_duedate)->format('h:i A') }}</span>
                                    </div>
                                    <div class="timeline-icon">
                                        <a href="javascript:void(0);"></a>
                                    </div>
                                    <div class="timeline-body">
                                        <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                                            @if ($m->submission_status == 'No Attempt')
                                                <div
                                                    class="avatar avatar-md  me-3 avatar-rounded mt-sm-0 mt-4 bg-warning-gradient">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-hourglass-bottom"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2z" />
                                                    </svg>
                                                </div>
                                            @elseif ($m->submission_status == 'Overdue')
                                                <div class="avatar avatar-md  me-3 avatar-rounded mt-sm-0 mt-4 bg-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-hourglass-bottom"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2z" />
                                                    </svg>
                                                </div>
                                            @elseif($m->submission_status == 'Submitted')
                                                <div
                                                    class="avatar avatar-md me-3 avatar-rounded mt-sm-0 mt-4 bg-success-gradient">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-clipboard-check-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                                                        <path
                                                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                                    </svg>
                                                </div>
                                            @elseif($m->submission_status == 'Open')
                                                <div
                                                    class="avatar avatar-md  me-3 avatar-rounded mt-sm-0 mt-4 bg-warning-gradient">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                                        <path
                                                            d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div
                                                    class="avatar avatar-md  me-3 avatar-rounded mt-sm-0 mt-4 bg-danger-gradient">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                        <path
                                                            d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center">
                                                    <div class="mt-sm-0 mt-2">
                                                        <p class="mb-0 fs-14 fw-semibold">{{ $m->act_name }}</p>
                                                        <p class="mb-0 text-muted">Document that need to submit is
                                                            <span
                                                                class="badge bg-primary-transparent fw-semibold mx-1">{{ $m->doc_name }}</span>
                                                        </p>
                                                    </div>
                                                    @if ($m->submission_status == 'No Attempt' || $m->submission_status == 'Open')
                                                        <div class="ms-auto">
                                                            <a href={{ route('documentsubmission', $m->id) }}
                                                                class="btn btn-icon btn-sm btn-primary-transparent rounded-pill">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </a>
                                                        </div>
                                                    @elseif ($m->submission_status == 'Submitted')
                                                        <div class="ms-auto">
                                                            <a href={{ route('studentActivity') }}
                                                                class="btn btn-icon btn-sm btn-primary-transparent rounded-pill my-2">
                                                                <i class="bi bi-eye-fill"></i>
                                                            </a>
                                                            <a href={{ route('finalDocDown', ['act' => $m->activity_id, 'stud' => auth()->user()->id]) }}
                                                                class="btn btn-icon btn-sm btn-primary rounded-pill my-2">
                                                                <i class="bi bi-box-arrow-down"></i>
                                                            </a>
                                                        </div>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>


            </div>
        </div>


        @include('student.layouts.footer')

    </div>
@endsection
