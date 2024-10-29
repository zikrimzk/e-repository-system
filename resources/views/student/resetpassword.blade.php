@extends('student.layouts.main')

@section('content')
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <body style="background: white;">
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
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

                    <div class="card custom-card shadow-lg" style="background:transparent">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="../assets/images/brand-logos/e-Repository.png" alt="logo" width="140px">
                            </div>
                            <p class="mb-4 text-muted op-7 fw-normal text-center">Please enter your new password.</p>
                            <form action="{{ route('resetStudentPassword',$data->id) }}" method="POST">
                                @csrf
                                <div class="col-xl-12">
                                    <label for="password" class="form-label text-default">New Password</label>
                                    <input type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror "
                                        name="password" id="password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <label for="repassword" class="form-label text-default">Confirm Password</label>
                                    <input type="password"
                                        class="form-control form-control-lg @error('repassword') is-invalid @enderror "
                                        name="repassword" id="repassword">
                                    @error('repassword')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 d-grid mt-4">
                                    <button type="submit" class="btn btn-lg btn-primary">Reset Password</button>
                                </div>

                            </form>
                            {{-- End Login Form --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Bootstrap JS -->
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Show Password JS -->
        <script src="../assets/js/show-password.js"></script>

    </body>
@endsection
