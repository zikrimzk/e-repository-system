@extends('staff.layouts.main')


@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Update Profile</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a
                                        href="javascript:void(0);">{{ Auth::guard('staff')->user()->sname }}</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('staffProfile') }}">Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Profile</li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <a href="{{ route('staffProfile') }}" class="btn btn-primary-transparent btn-sm"><i class='bx bx-arrow-back align-middle me-1'></i> Back</a>
                </div>  

                <!-- Start Alert -->
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
                <!-- End Alert -->

                <div class="row justify-content-center">

                    <!-- Personal Detail Section -->
                    <div class="col-sm-8">
                        <div class="card custom-card shadow-lg">
                            <div class="card-header">
                                <div class="card-title">
                                    Personal Details
                                </div>
                            </div>
                            <form class="row" method="POST"
                                action="{{ route('staffProfileUpdatePost', auth()->user()->id) }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Staff No. -->
                                        <div class="col-md-12">
                                            <label for="staffNo" class="form-label">Staff No.</label>
                                            <input type="text" class="form-control border-white"
                                                value="{{ auth()->user()->staffNo }}" readonly />
                                        </div>

                                        <!-- Full Name -->
                                        <div class="col-md-12">
                                            <label for="staffName" class="form-label">Full Name <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('sname') is-invalid @enderror bg-light"
                                                name="sname" id="staffName" placeholder="First name"
                                                value="{{ auth()->user()->sname }}">
                                            @error('sname')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Email -->
                                        <div class="col-md-12">
                                            <label for="staffEmail" class="form-label">Email <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror bg-light"
                                                name="email" id="staffEmail" placeholder="UTem Email"
                                                value="{{ auth()->user()->email }}">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Phone No. -->
                                        <div class="col-md-12">
                                            <label for="staffphoneNo" class="form-label">Phone No. <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('sphoneNo') is-invalid @enderror bg-light"
                                                name="sphoneNo" id="staffphoneNo"placeholder="Phone Number"
                                                value="{{ auth()->user()->sphoneNo }}">
                                            @error('sphone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Department -->
                                        <div class="col-md-12">
                                            <label for="staffDepartment" class="form-label">Department</label>
                                            <input type="text" class="form-control border-white"
                                                value="{{ DB::table('departments')->where('id', Auth::guard('staff')->user()->dep_id)->first()->dep_name }}"
                                                readonly />
                                        </div>
                                        <!-- Role -->
                                        <div class="col-md-12">
                                            <label for="staffRole" class="form-label">Role</label>
                                            <input type="text" class="form-control border-white"
                                                value="{{ auth()->user()->srole }}" readonly />
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- Personal Detail Section -->


                    <!-- Password Section -->
                    <div class="col-sm-8">
                        <div class="card custom-card shadow-lg">
                            <div class="card-header">
                                <div class="card-title">
                                    Password Setting
                                </div>
                            </div>
                            <form class="row" method="POST" action="{{ route('staffProfileUpdatePasswordPost',auth()->user()->id) }}">
                                @csrf
                                <div class="card-body">
                                    <div class="row g-3">

                                        <!-- Old Password -->
                                        <div class="col-md-12">
                                            <label for="oldPass" class="form-label">Old Password <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('oldPass') is-invalid @enderror bg-light"
                                                name="oldPass" id="oldPass" placeholder="Old Password">
                                            @error('oldPass')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- New Password -->
                                        <div class="col-md-12">
                                            <label for="newPass" class="form-label">New Password <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('newPass') is-invalid @enderror bg-light"
                                                name="newPass" id="newPass" placeholder="New Password">
                                            @error('newPass')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Confirm New Password -->
                                        <div class="col-md-12">
                                            <label for="renewPass" class="form-label">Confirm Password <span
                                                    class="fw-bold text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('renewPass') is-invalid @enderror bg-light"
                                                name="renewPass" id="renewPass" placeholder="Confirm Password">
                                            @error('renewPass')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- Password Section -->


                </div>

            </div>
        </div>
        <!-- End::app-content -->

        @include('staff.layouts.footer')

    </div>
@endsection
