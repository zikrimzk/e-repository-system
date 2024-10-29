@extends('staff.layouts.main')


@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript:void(0);">{{ Auth::guard('staff')->user()->sname }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <div class="row">
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body p-0">
                                <div
                                    class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover bg-info-gradient">
                                    <div class="flex-fill main-profile-info ">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold mb-1 text-fixed-white text-uppercase">
                                                {{ Auth::guard('staff')->user()->sname }}</h6>
                                            <a href="{{ route('staffProfileEdit') }}"
                                                class="btn btn-light btn-wave btn-sm"><i
                                                    class='bx bxs-edit me-1 align-middle d-inline-block'></i>Edit
                                                Profile</a>
                                        </div>
                                        <p class="mb-1 text-muted text-fixed-white op-7">
                                            {{ DB::table('departments')->where('id', Auth::guard('staff')->user()->dep_id)->first()->dep_name }}
                                        </p>
                                        <p class="mb-1 text-muted text-fixed-white op-7">
                                            {{ Auth::guard('staff')->user()->srole }}</p>
                                    </div>
                                </div>
                                <div class="p-4 border-bottom border-block-end-dashed">
                                    <p class="fs-15 mb-2 me-4 fw-semibold">Personal Information :</p>
                                    <div class="text-muted">
                                        <p class="mb-2">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="ri-mail-line align-middle fs-14"></i>
                                            </span>
                                            {{ Auth::guard('staff')->user()->email }}
                                        </p>
                                        <p class="mb-2">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="ri-phone-line align-middle fs-14"></i>
                                            </span>
                                            {{ Auth::guard('staff')->user()->sphoneNo }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End::app-content -->

        @include('staff.layouts.footer')

    </div>
@endsection
