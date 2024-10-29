<?php

use App\Models\Activity;
use App\Models\ActivityProgramme;
 
?>

<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <div class="text-center side-menu__label">
            @if(Auth::guard('staff')->user()->srole == 'Timbalan Dekan Pendidikan')
                TDP Panel 
            @else
                {{ Auth::guard('staff')->user()->srole }} Panel
            @endif
        </div>
    </div>



    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">

                {{-- Category MAIN --}}
                <li class="slide__category"><span class="category-name">Main</span></li>

                <li class="slide">
                    <a href="{{ route('staffHome') }}" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>



                {{-- Category ADMIN --}}
                <li class="slide__category"><span class="category-name">Administration</span></li>
                @if (Auth::guard('staff')->user()->srole != 'Timbalan Dekan Pendidikan')
                    {{-- My Supervision --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bxs-user-badge side-menu__icon'></i>
                            <span class="side-menu__label">My Supervision</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('mysvstudentlist') }}" class="side-menu__item">Student</a>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Submission
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu rounded-md child2 ">
                                    <li class="slide ">
                                        <a href="{{ route('mysvsubmissionManagement') }}"
                                            class="side-menu__item">Submission Management</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('mysvsubmissionApproval') }}"
                                            class="side-menu__item">Submission Approval</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="{{ route('mysvnomination') }}" class="side-menu__item">Nomination</a>
                            </li>
                        </ul>
                    </li>

                    {{-- My Evaluation --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bxs-pen side-menu__icon'></i>
                            <span class="side-menu__label">My Evaluation</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <span style="display:none;">
                                {{ $data = DB::table('activity_programmes as a')->where('is_haveEva','1')->select('a.activities_id')->get()}}
                                {{ $data2 = Activity::all() }}
                                {{ $unique = $data->unique() }}
                            </span>

                            @foreach($unique->values()->all() as $a)
                                @foreach($data2 as $b)
                                        <li class="slide">
                                            @if($b->id == $a->activities_id)
                                                <a href="{{ route('myevaluationManagement',$a->activities_id ) }}" class="side-menu__item">{{ $b->act_name }}</a>
                                            @endif
                                        </li>
                                @endforeach 
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bxs-user-badge side-menu__icon'></i>
                            <span class="side-menu__label">Student</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('studentManagement') }}" class="side-menu__item">Student List</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('adminsubmissionApproval') }}" class="side-menu__item">Submission Approval</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Auth::guard('staff')->user()->srole == 'Committee')
                    {{-- STUDENT --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bxs-user-plus side-menu__icon'></i>
                            <span class="side-menu__label">Supervision</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('studentSupervision') }}" class="side-menu__item">Supervision
                                    Arragement</a>
                            </li>                    
                            <li class="slide">
                                <a href="{{ route('studentManagement') }}" class="side-menu__item">Student
                                    Management</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('staffManagement') }}" class="side-menu__item">Staff Management</a>
                            </li>

                        </ul>
                    </li>

                    <li class="slide">
                        <a href="{{ route('evaluationArragement') }}" class="side-menu__item">
                            <i class='bx bx-pen side-menu__icon'></i>
                            <span class="side-menu__label">Evaluation</span>
                        </a>
                    </li>

                    {{-- Submission --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bx-upload side-menu__icon'></i>
                            <span class="side-menu__label">Submission</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>

                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('submissionAllManagement') }}" class="side-menu__item">Submission
                                    Management</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('suggestionSystem') }}" class="side-menu__item">Suggestion</a>
                            </li>
                            {{-- <li class="slide">
                            <a href="##" class="side-menu__item">Approval</a>
                        </li>
                        <li class="slide">
                            <a href="##" class="side-menu__item">Status</a>
                        </li> --}}
                        </ul>
                    </li>
                    <li class="slide">
                        <a href="{{ route('nominationManagement') }}" class="side-menu__item">
                            <i class='bx bx-group side-menu__icon'></i>
                            <span class="side-menu__label">Nomination</span>
                        </a>
                    </li>

                    {{-- SOP --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class='bx bxs-folder-open side-menu__icon'></i>
                            <span class="side-menu__label">SOP</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 ">
                            <li class="slide">
                                <a href="{{ route('procedureManagement') }}" class="side-menu__item">Procedure
                                    Setting</a>
                            </li>
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">Activity
                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                <ul class="slide-menu rounded-md child2 ">
                                    <li class="slide ">
                                        <a href="{{ route('activitySetting') }}" class="side-menu__item">Activity
                                            Setting</a>
                                    </li>
                                    <li class="slide">
                                        <a href="{{ route('formSetting') }}" class="side-menu__item">Form Setting</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a href="{{ route('docManagement') }}" class="side-menu__item">Document Setting</a>
                            </li>

                        </ul>
                    </li>

                   

                    {{-- Category Setting --}}
                    <li class="slide__category"><span class="category-name">System Setting</span></li>
                    {{-- Programme --}}
                    <li class="slide has-sub">
                        <a class="side-menu__item">
                            <i class="bx bx-cog header-link-icon side-menu__icon"></i>
                            <span class="side-menu__label">Setting</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide">
                                <a href="{{ route('semesterManagement') }}" class="side-menu__item">Semester
                                    Setting</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('facultySetting') }}" class="side-menu__item">Faculty Setting</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('programmeManagement') }}" class="side-menu__item">Programme
                                    Setting</a>
                            </li>
                            
                            <li class="slide">
                                <a href="{{ route('departmentSetting') }}" class="side-menu__item">Department
                                    Setting</a>
                            </li>
                            <li class="slide">
                                <a href="javascript:void(0);" data-bs-toggle="offcanvas"
                                    data-bs-target="#switcher-canvas" class="side-menu__item">System Setting</a>
                            </li>
                            {{-- <li class="slide">
                            <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas" class="side-menu__label">
                               System Setting
                            </a>
                           
                        </li> --}}

                        </ul>
                    </li>
                @endif









            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>


    </div>


</aside>
