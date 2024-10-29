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
                    <div class="card custom-card shadow-lg" style="background: transparent" id="login-card">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-center">
                                <img src="../assets/images/brand-logos/e-Repository.png" alt="logo" width="140px">
                            </div>

                            <p class="mb-4 text-muted op-7 fw-normal text-center">Student Gateway</p>
                            {{-- Login Form --}}
                            <form action="{{ route('loginStudent') }}" method="POST">
                                @csrf
                                <div class="row gy-3">

                                    <div class="col-xl-12">
                                        <label for="email" class="form-label text-default">Email</label>
                                        <input type="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="Student email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-12 mb-2">
                                        <label for="password" class="form-label text-default d-block">Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                name="password" id="password" placeholder="Password">
                                            <button class="btn btn-light" type="button" id="button-addon2"
                                                onclick="createpassword('password',this)"><i
                                                    class="ri-eye-off-line align-middle"></i></button>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <label for="signin-password" class="form-label text-default d-block"><a
                                                href="{{ route('studentResetPasswordRequest') }}"
                                                class="float-end text-primary">Forget password ?</a></label>
                                    </div>

                                    <div class="col-xl-12 d-grid mt-2">
                                        <button type="submit" class="btn btn-lg btn-primary">Login</button>
                                    </div>

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





















{{-- <form method="POST" action="{{ route('loginStudent') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}
