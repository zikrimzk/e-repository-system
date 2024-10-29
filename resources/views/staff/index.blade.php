@extends('staff.layouts.main')


@section('content')
    <style type="text/css" media="print">
        body {
            visibility: hidden;
        }

        .no-print {
            visibility: hidden;
        } 

        .print {
            visibility: visible;
        }
    </style>
    <div class="page">
        <div class="main-content app-content">
            <div class="container print">

                <div class="row ">
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <div>
                            <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()->sname }} !</p>
                            <span class="fw-semibold text-muted fs-14">Dashboard</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-primary-transparent no-print" onclick="window.print();return false;">
                                <i class='bx bxs-printer me-1'></i>
                                Print Report
                            </button>
                        </div>
                    </div>
                </div>
                <!--Committee Dashboard-->
                @if (auth()->user()->srole == 'Committee')
                    <div class="row mb-1">
                        <h1 class="text-dark fw-semibold fs-14">Committee Panel</h1>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12">
                            <div class="row">

                                <!--Student Status Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student Status</p>
                                            {!! $chartstudent->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Student Status Charts -->

                                <!--Staff Roles Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card ">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Staff By Roles</p>
                                            {!! $chartstaff->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Staff Roles Charts -->


                            </div>
                            <div class="row">
                                <!--Total Student-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Student</p>
                                                <span class="badge badge-pills bg-primary-gradient mb-2">All</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalStudent }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-primary-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        fill="currentColor" class="bi bi-person-badge-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('studentManagement') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Total Student-->

                                <!--Total Staff-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Staff</p>
                                                <span class="badge badge-pills bg-primary-gradient mb-2">All</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalStaff }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-primary-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-person-fill-gear"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('staffManagement') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Total Staff-->

                            </div>
                            <div class="row">
                                <!--Student By Programmes Charts -->
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student By Programme</p>
                                            {!! $chartpstu->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Student By Programmes Charts -->
                            </div>
                        </div>

                    </div>
                @endif
                <!--End Committee Dashboard-->

                <!--TDP Dashboard-->
                @if (auth()->user()->srole == 'Timbalan Dekan Pendidikan')
                    <div class="row mb-1">
                        <h1 class="text-dark fw-semibold fs-14">Timbalan Dekan Pendidikan Panel</h1>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12">

                            <div class="row">
                                <!--Total Student-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Student</p>
                                                <span class="badge badge-pills bg-primary-gradient mb-2">All</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalStudent }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-primary-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                        fill="currentColor" class="bi bi-person-badge-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('studentManagement') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Total Student-->

                                <!--Approval Required-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Approval Required</p>
                                                <span class="badge badge-pills bg-danger-gradient mb-2">Need
                                                    Attention</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalApptdp }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-danger-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                        <path
                                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('adminsubmissionApproval') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Approval Required-->
                            </div>
                            <div class="row">

                                <!--Student Status Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student Status</p>
                                            {!! $chartstudent->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Student Status Charts -->

                                <!--Student By Programme Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student By Programme</p>
                                            {!! $chartpstu->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Student By Programme Charts -->

                            </div>
                        </div>

                    </div>
                @endif
                <!--End TDP Dashboard-->

                <!--Both Comm & Lect-->
                @if (auth()->user()->srole == 'Committee' || auth()->user()->srole == 'Lecturer')
                    <div class="row mb-1">
                        <h1 class="text-dark fw-semibold fs-14">Supervisor Panel</h1>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12">
                            <div class="row">

                                <!--Supervisor-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Supervision</p>
                                                <span class="badge badge-pills bg-success-gradient mb-2">Supervisor</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalSv }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-success-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-person-workspace"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                                        <path
                                                            d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('mysvstudentlist') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Supervisor-->

                                <!--Co-Supervisor-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Supervision</p>
                                                <span
                                                    class="badge badge-pills bg-success-gradient mb-2">Co-Supervisor</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalCSv }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-success-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('mysvstudentlist') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Co-Supervisor-->

                                <!--Student by Programme Charts -->
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student By Programme (My Supervison)</p>
                                            {!! $chartsvpstu->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End  by Programme Charts -->

                                <!--Approval Required-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Approval Required</p>
                                                <span class="badge badge-pills bg-danger-gradient mb-2">Need
                                                    Attention</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalApp }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-danger-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-check2-circle"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                        <path
                                                            d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('mysvsubmissionApproval') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Approval Required-->

                                <!--Nomination Required-->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card">
                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>
                                                <p class="fw-semibold mb-0">Total Nomination Required</p>
                                                <span class="badge badge-pills bg-danger-gradient mb-2">Need
                                                    Attention</span>
                                                <h4 class="fw-semibold mb-2">{{ $totalNom }}</h4>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-md bg-danger-gradient p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-person-raised-hand"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a.998.998 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207" />
                                                        <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                                                    </svg>
                                                </span>
                                                <a href="{{ route('mysvnomination') }}"
                                                    class="text-primary fs-12 ms-2 me-2 ">View All<i
                                                        class="ti ti-arrow-narrow-right fw-semibold d-inline-block"></i></a>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <!--End Nomination Required-->

                            </div>
                            <div class="row">
                                <!--Student Submitted Doc Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student Submitted Document</p>
                                            {!! $chartsvsub->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Student Submitted Doc Charts -->

                                <!--Student UnAttempt Doc Charts -->
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <p class="fw-semibold mb-0">Student No Attempt Document</p>
                                            {!! $chartsvnosub->container() !!}
                                        </div>
                                    </div>
                                </div>
                                <!--End Student UnAttempt Doc Charts -->
                            </div>
                        </div>
                    </div>
                @endif
                <!--End Both Comm & Lect-->

            </div>


        </div>


        @include('staff.layouts.footer')

        <script src="{{ $chartstudent->cdn() }}"></script>
        {{ $chartstudent->script() }}

        <script src="{{ $chartstaff->cdn() }}"></script>
        {{ $chartstaff->script() }}

        <script src="{{ $chartsvsub->cdn() }}"></script>
        {{ $chartsvsub->script() }}

        <script src="{{ $chartsvnosub->cdn() }}"></script>
        {{ $chartsvnosub->script() }}

        <script src="{{ $chartpstu->cdn() }}"></script>
        {{ $chartpstu->script() }}

        <script src="{{ $chartsvpstu->cdn() }}"></script>
        {{ $chartsvpstu->script() }}

    </div>
@endsection
<!--Done 31/12/2023 -->
