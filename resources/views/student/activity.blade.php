<?php

use Carbon\Carbon;
?>

@extends('student.layouts.main')


@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">
                @if ($check)
                    <!-- Page Header -->
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <h1 class="page-title fw-bold fs-24 mb-0">Course Activity</h1>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('studentActivity') }}">{{ Auth::user()->programme->prog_code }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Activity</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <div>
                            <span class="d-block text-muted fs-12">Title of Research</span>
                            <div class="d-flex align-items-center">
                                <span class="d-block fs-18 fw-semibold">{{ auth()->user()->titleOfResearch }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Page Header Close -->

                    <!-- Start Alert -->
                    @if (session()->has('success'))
                        <div class="alert alert-secondary alert-dismissible fade show custom-alert-icon shadow-sm"
                            role="alert">
                            <svg class="svg-secondary" xmlns="http://www.w3.org/2000/svg" height="1.5rem"
                                viewBox="0 0 24 24" width="1.5rem" fill="#000000">
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
                        <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm"
                            role="alert">
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
                    <!-- End Alert -->





                    <div class="row">
                        @foreach ($acts as $act)
                            <div class="card custom-card" id="test{{ $loop->iteration }}">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">{{ $act->act_name }}</div>
                                    @if (
                                        $task->where('activity_id', $act->activities_id)->count() != 0 &&
                                            $sa->where('activity_id', $act->activities_id)->count() <= 0)
                                        <div class="btn-list">
                                            <a href="{{ route('studentEachActivity', $act->activities_id) }}"
                                                class="btn btn-primary btn-sm btn-wave me-0"><i
                                                    class='bx bxs-chevrons-right me-1 align-middle'></i>Go to Activity</a>
                                        </div>
                                    @elseif(
                                        $sa->where('activity_id', $act->activities_id)->count() >= 1 &&
                                            $sa->where('activity_id', $act->activities_id)->first()->ac_status == 'Rejected')
                                        <div class="btn-list">
                                            <a href="{{ route('studentEachActivity', $act->activities_id) }}"
                                                class="btn btn-danger btn-sm btn-wave me-0"><i
                                                    class='bx bxs-chevrons-right me-1 align-middle'></i>Go to Activity</a>
                                        </div>
                                    @endif

                                </div>

                                <div class="card-body">
                                    @if ($act->meterial != null)
                                        <div class ="fs-12 fw-bold mb-2">Flowchart :</div>
                                        <p class="text-muted task-description">
                                            <a href="{{ route('materialDown', ['act' => $act->activities_id, 'prog' => $act->programmes_id]) }}"
                                                class="me-0 text-primary"><i
                                                    class='bx bxs-file bx-burst  me-1 align-middle'></i>{{ $act->meterial }}</a>
                                        </p>
                                    @endif
                                    @if ($sa->where('activity_id', $act->activities_id)->count() >= 1)
                                        <div class ="fs-12 fw-bold mb-2">Final Documents :</div>
                                        <p class="text-muted task-description">
                                            <a href="{{ route('finalDocDown', ['act' => $act->activities_id, 'stud' => auth()->user()->id]) }}"
                                                class="me-0 text-primary"><i
                                                    class='bx bxs-file bx-burst  me-1 align-middle'></i>{{ $sa->where('activity_id', $act->activities_id)->first()->ac_form }}</a>
                                        </p>
                                    @endif
                                    @if (
                                        $sa->where('activity_id', $act->activities_id)->count() >= 1 &&
                                            $rv->where('stuact_id', $sa->where('activity_id', $act->activities_id)->first()->id)->count() >= 1)
                                        <div class ="fs-12 fw-bold mb-2">Comment :</div>
                                        <p class="text-muted task-description">

                                            {{ $rv->where('stuact_id', $sa->where('activity_id', $act->activities_id)->first()->id)->first()->r_comment }}

                                        </p>
                                    @endif
                                    <span style="display: none;">{{ $isAssign = false }}</span>
                                    <li style="display: none;">{{ $date = Carbon::parse(new DateTime('now')) }}</li>
                                    @if ($task->where('activity_id', $act->activities_id)->count() != 0)
                                        <span style="display: none;">{{ $isAssign = true }}</span>
                                        <div class="fs-12 fw-bold mb-2">Submission involve :</div>
                                        <div>
                                            <ul class="fs-12 text-muted mb-0">
                                                @foreach ($task->where('activity_id', $act->activities_id) as $tasks)
                                                    <li style="display: none;">{{ $date = $tasks->submission_duedate }}
                                                    </li>
                                                    <li>{{ $tasks->doc_name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <span style="display: none;">{{ $isAssign = false }}</span>
                                        <li style="display: none;">{{ $DateUnAssign = '-' }}</li>
                                    @endif
                                </div>

                                <div class="card-footer">
                                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">

                                        <div>
                                            {{-- @dd($task->where('activity_id',2)->where('submission_status','No Attempt')->count()) --}}
                                            @if (
                                                $task->where('activity_id', $act->activities_id)->where('submission_status', 'No Attempt')->count() != 0 ||
                                                    $task->where('activity_id', $act->activities_id)->where('submission_status', 'Overdue')->count() != 0 ||
                                                    $task->where('activity_id', $act->activities_id)->where('submission_status', 'Open')->count() != 0 ||
                                                    $isAssign == false)
                                                <span class="d-block text-muted fs-12">Due Date</span>
                                                <span class="d-block fs-14 fw-semibold">
                                                    @if ($isAssign)
                                                        {{ Carbon::parse($date)->format('d M Y , h:i A') }}
                                                    @else
                                                        {{ $DateUnAssign }}
                                                    @endif
                                                </span>
                                            @else
                                                <span class="d-block text-muted fs-12">Submission Date</span>
                                                <span
                                                    class="d-block fs-14 fw-semibold">{{ Carbon::parse($tasks->submission_date)->format('d M Y , h:i A') }}</span>
                                            @endif
                                        </div>
                                        @if (
                                            $task->where('activity_id', $act->activities_id)->where('submission_status', 'No Attempt')->count() != 0 ||
                                                $task->where('activity_id', $act->activities_id)->where('submission_status', 'Overdue')->count() != 0 ||
                                                $task->where('activity_id', $act->activities_id)->where('submission_status', 'Open')->count() != 0 ||
                                                $isAssign == false)
                                            @if (Carbon::parse($date) < Carbon::parse(new DateTime('now')) && $isAssign)
                                                <div>
                                                    <span class="d-block text-muted fs-12">Overdue by</span>
                                                    <span class="d-block fs-14 fw-semibold text-danger">
                                                        {{ $days = Carbon::parse(Carbon::parse($date))->diffInDays(new DateTime('now')) }}
                                                        days
                                                        {{ $hours = Carbon::parse(Carbon::parse($date))->copy()->addDays($days)->diffInHours(new DateTime('now')) }}
                                                        hours
                                                        {{ $minutes = Carbon::parse(Carbon::parse($date))->copy()->addDays($days)->addHours($hours)->diffInMinutes(new DateTime('now')) }}
                                                        minutes

                                                    </span>
                                                </div>
                                            @elseif(Carbon::parse($date) > Carbon::parse(new DateTime('now')) && $isAssign)
                                                <div>
                                                    <span class="d-block text-muted fs-12">Time Remaining</span>
                                                    <span class="d-block fs-14 fw-semibold ">
                                                        {{ $days = Carbon::parse(new DateTime('now'))->diffInDays(Carbon::parse($date)) }}
                                                        days
                                                        {{ $hours = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->diffInHours(Carbon::parse($date)) }}
                                                        hours
                                                        {{ $minutes = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->addHours($hours)->diffInMinutes(Carbon::parse($date)) }}
                                                        minutes

                                                    </span>
                                                </div>
                                            @else
                                                <div>
                                                    <span class="d-block text-muted fs-12">Time Remaining</span>
                                                    <span class="d-block fs-14 fw-semibold ">-</span>
                                                </div>
                                            @endif
                                        @else
                                            <div>
                                                @if ($sa->where('activity_id', $act->activities_id)->count() >= 1)
                                                    <span class="d-block text-muted fs-12">Status</span>
                                                    @if ($sa->where('activity_id', $act->activities_id)->first()->ac_status == 'Rejected')
                                                        <span
                                                            class="badge bg-danger fs-12">{{ $sa->where('activity_id', $act->activities_id)->first()->ac_status }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-outline-success fs-12">{{ $sa->where('activity_id', $act->activities_id)->first()->ac_status }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <input type="hidden" id="val" value="{{ $acts->count() }}">
                    </div>
                    
                @else
                    <div class="container">
                        <div class="text-center p-5 my-auto">
                            <div class="row align-items-center justify-content-center h-100">
                                <div class="col-xl-7">
                                    <p class="error-text mb-sm-0 mb-2">SORRY</p>
                                    <p class="fs-18 fw-semibold mb-3">Oops &#128557;,The page you are looking for is
                                        restricted.</p>
                                    <div class="row justify-content-center mb-5">
                                        <div class="col-xl-6">
                                            <p class="mb-0 op-7">
                                                We apologize for the inconvenience caused.
                                                Please note that you have not been assigned a supervisor yet.
                                                The activity will become visible to you once the committee has assigned
                                                a supervisor to you. If you encounter any issues, we kindly request you
                                                to contact the committee for assistance. Thank you for your
                                                understanding.
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('studentHome') }}" class="btn btn-primary"><i
                                            class="ri-arrow-left-line align-middle me-1 d-inline-block"></i>BACK TO
                                        HOME</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif




            </div>
        </div>
        <!-- End::app-content -->
        <script>
            $(document).ready(function() {

                let max = $('#val').val()
                console.log(max);

                for (let i = 1; i <= max; i++) {
                    console.log(i);
                    $('#test' + i).on('mouseenter', function() {
                        $(this).attr('style', 'transform:scale(1.01);transition:transform 0.3s linear')
                    });
                    $('#test' + i).on('mouseleave', function() {
                        $(this).attr('style', 'transform:scale(1.0);transition:transform 0.3s linear')
                    });
                }

            });
        </script>

        @include('student.layouts.footer')

    </div>
@endsection
