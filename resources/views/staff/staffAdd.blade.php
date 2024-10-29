@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Staff Registration</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Supervision</li>
                                <li class="breadcrumb-item"><a href="{{ route('staffManagement') }}">Staff Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Registration</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="card custom-card shadow-lg">
                        <!--Start Form-->
                        <form class="row" method="POST" action="{{ route('staffPost') }}">
                            @csrf
                            <div class="card-body">
                                <div class="fs-14 fw-semibold mb-2">Instructions :</div>
                                <ul class="task-details-key-tasks">
                                    <li class="text-dark fs-12">Please complete the following fields to register as a
                                        staff.
                                    </li>
                                    <li class="text-dark fs-12">Ensure all information is accurate and complete. </li>
                                    <li class="text-dark fs-12">Fields marked with an asterisk (<span
                                            class="fw-bold text-danger">*</span>) are mandatory. </li>
                                </ul>
                                <div class="row g-3 mt-0">
                                    <!-- Full Name -->
                                    <div class="col-md-4">
                                        <label for="staffName" class="form-label">Full Name <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('sname') is-invalid @enderror bg-light"
                                            name="sname" id="staffName" placeholder="First name"
                                            value="{{ old('sname') }}">
                                        @error('sname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-4">
                                        <label for="staffEmail" class="form-label">Email <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror  bg-light"
                                            name="email" id="staffEmail" placeholder="e.g. a2200@staff.utem.edu.my"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Phone No. -->
                                    <div class="col-md-4">
                                        <label for="staffphoneNo" class="form-label">Phone No. <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('sphoneNo') is-invalid @enderror  bg-light"
                                            name="sphoneNo" id="staffphoneNo"placeholder="e.g. 0126645325"
                                            value="{{ old('sphoneNo') }}">
                                        @error('sphoneNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Staff No. -->
                                    <div class="col-md-4">
                                        <label for="staffNo" class="form-label">Staff No. <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('staffNo') is-invalid @enderror  bg-light"
                                            name="staffNo" id="staffNo" placeholder="Staff ID"
                                            value="{{ old('staffNo') }}">
                                        @error('staffNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Departments -->
                                    <div class="col-md-4">
                                        <label for="staffDepartment" class="form-label">Department <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('dep_id') is-invalid @enderror  bg-light"
                                            name="dep_id" id="staffDepartment">
                                            <option selected disabled>Select</option>
                                            @foreach ($depts as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->dep_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dep_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Role -->
                                    <div class="col-md-4">
                                        <label for="staffRole" class="form-label">Role <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('srole') is-invalid @enderror  bg-light"
                                            name="srole" id="staffRole" value="{{ old('srole') }}">
                                            <option selected disabled>Select</option>
                                            <option>Committee</option>
                                            <option>Lecturer</option>
                                            <option>Timbalan Dekan Pendidikan</option>
                                            <option>Dekan</option>
                                        </select>
                                        @error('srole')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <label for="staffPassword" class="form-label">Password <span
                                                class="fw-bold text-muted">(Default : 12345678)</span></label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror  bg-light"
                                            name="password" id="staffPassword" value="12345678">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- RePassword -->
                                    <div class="col-md-6">
                                        <label for="staffre-Password" class="form-label">Confirm Password <span
                                            class="fw-bold text-muted">(Default : 12345678)</span></label>
                                        <input type="password"
                                            class="form-control @error('repassword') is-invalid @enderror  bg-light"
                                            name="repassword" id="staffre-Password" value="12345678" >
                                        @error('repassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary-transparent btn-sm">Register</button>
                                <a href="{{ route('staffManagement') }}"
                                    class="btn btn-danger-transparent btn-sm">Cancel</a>
                            </div>
                        </form>
                        <!--End Form-->
                    </div>
                </div>

            </div>
        </div>

        @include('Staff.layouts.footer')

    </div>
@endsection
<!--Done 13/12/2023-->
<!--Done Update Department 23/12/2023-->
