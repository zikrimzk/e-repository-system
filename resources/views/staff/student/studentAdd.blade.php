@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Student Registration</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Supervision</li>
                                <li class="breadcrumb-item"><a href="{{ route('staffManagement') }}">Student Management</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Registration</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <!-- Start Form -->
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="fs-14 fw-semibold mb-2">Instructions :</div>
                            <ul class="task-details-key-tasks">
                                <li class="text-dark fs-12">Please complete the following fields to register as a student.
                                </li>
                                <li class="text-dark fs-12">Ensure all information is accurate and complete. </li>
                                <li class="text-dark fs-12">Fields marked with an asterisk (<span
                                        class="fw-bold text-danger">*</span>) are mandatory. </li>
                            </ul>
                            <!-- Form -->
                            <form class="row" method="POST" action="{{ route('studentPost') }}" id="register">
                                @csrf
                                <div class="row g-3 mt-0">
                                    <!-- Full Name -->
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Full Name <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror bg-light" name="name"
                                            id="name" placeholder="Student name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror bg-light"
                                            name="email" id="email" placeholder="e.g. d032110319@student.utem.edu.my"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Phone Number -->
                                    <div class="col-md-4">
                                        <label for="phoneNo" class="form-label">Phone No. <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('phoneNo') is-invalid @enderror bg-light"
                                            name="phoneNo" id="phoneNo"placeholder="e.g. 0126645325"
                                            value="{{ old('phoneNo') }}">
                                        @error('phoneNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Gender -->
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Gender <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('gender') is-invalid @enderror bg-light"
                                            name="gender" id="gender">
                                            <option selected disabled>Select</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Status -->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror bg-light"
                                            name="status" id="status">
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Address -->
                                    <div class="col-md-4">
                                        <label for="address_one" class="form-label">Address
                                            <small>(optional)</small></label>
                                        <input type="text"
                                            class="form-control @error('address_one') is-invalid @enderror bg-light"
                                            name="address_one" id="address_one" value="{{ old('address_one') }}">
                                        @error('address_one')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Matric No -->
                                    <div class="col-md-3">
                                        <label for="matricNo" class="form-label">Matric No. <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('matricNo') is-invalid @enderror bg-light"
                                            name="matricNo" id="matricNo" placeholder="e.g. D032110319"
                                            value="{{ old('matricNo') }}">
                                        @error('matricNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Semester-->
                                    <div class="col-md-3">
                                        <label for="sem_name" class="form-label">Semester <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="hidden" name="semester_id" value="{{ $sem->id }}">
                                        <input type="text" class="form-control bg-light"
                                            id="sem_name"placeholder="Phone Number" value="{{ $sem->label }}"
                                            readonly />
                                    </div>
                                    <!-- Programme -->
                                    <div class="col-md-3">
                                        <label for="programme_id" class="form-label">Programme <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('programme_id') is-invalid @enderror bg-light"
                                            name="programme_id" id="programme_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($progs as $prog)
                                                <option value="{{ $prog->id }}">{{ $prog->prog_code }}
                                                    ({{ $prog->prog_mode }})</option>
                                            @endforeach
                                        </select>
                                        @error('programme_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Role -->
                                    <div class="col-md-3">
                                        <label for="role" class="form-label">Role <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text" class="form-control bg-light" name="role"
                                            id="role" placeholder="Phone Number" value="Student" readonly />
                                    </div>
                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password <span
                                            class="fw-bold text-muted">(Default : 12345678)</span></label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror bg-light"
                                            name="password" id="password" value="12345678">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Re Password -->
                                    <div class="col-md-6">
                                        <label for="repassword" class="form-label">Confirm Password <span
                                            class="fw-bold text-muted">(Default : 12345678)</span></label>
                                        <input type="password"
                                            class="form-control @error('repassword') is-invalid @enderror bg-light"
                                            name="repassword" id="repassword" value="12345678">
                                        @error('repassword')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary-transparent btn-sm"
                                id="submit">Register</button>
                            <a href="{{ route('studentManagement') }}"
                                class="btn btn-danger-transparent btn-sm">Cancel</a>
                        </div>
                    </div>
                    <!-- End Form -->
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#submit').on('click', function() {
                    $('#register').submit();
                });
            });
        </script>

        @include('staff.layouts.footer')

    </div>
@endsection
<!--Done 5/12/2023-->
