@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Add Programme</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active" aria-current="page">Setting</li>
                                <li class="breadcrumb-item"><a href="{{ route('programmeManagement') }}">Programme
                                        Setting</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Programme</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <a href="{{ route('programmeManagement') }}" class="btn btn-primary-transparent btn-sm"><i
                            class='bx bx-arrow-back align-middle me-1'></i> Back</a>
                </div>


                <div class="row">
                    <div class="card custom-card">
                        <form method="POST" action="{{ route('programmePost') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Programme Name -->
                                    <div class="col-md-5">
                                        <label for="name" class="form-label">Programme Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control @error('prog_name') is-invalid @enderror"
                                            name="prog_name" id="name" placeholder="Programme Name"
                                            value="{{ old('prog_name') }}">
                                        @error('prog_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Programme Code -->
                                    <div class="col-md-5">
                                        <label for="code" class="form-label">Programme Code <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" class="form-control @error('prog_code') is-invalid @enderror"
                                            name="prog_code" id="code" placeholder="eg. MITA / PITA "
                                            value="{{ old('prog_code') }}">
                                        @error('prog_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Programme Mode -->
                                    <div class="col-md-5">
                                        <label for="faculty" class="form-label">Mode <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('prog_mode') is-invalid @enderror"
                                            name="prog_mode" id="mode">
                                            <option selected disabled>Select</option>
                                            <option value="FT">Full-Time</option>
                                            <option value="PT">Part-Time</option>
                                        </select>
                                        @error('prog_mode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Faculty -->
                                    <div class="col-md-5">
                                        <label for="faculty" class="form-label">Faculty <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('fac_id') is-invalid @enderror" name="fac_id"
                                            id="faculty">
                                            <option selected disabled>Select</option>
                                            @foreach ($fac as $f)
                                                <option value="{{ $f->id }}">{{ $f->fac_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('fac_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>


                            </div>
                            <div class="card-footer">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-primary-transparent btn-sm">Add
                                        Programme</button>
                                    <a href="{{ route('programmeManagement') }}"
                                        class="btn btn-danger-transparent btn-sm">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        @include('Staff.layouts.footer')

    </div>
@endsection
<!-- DONE 29/12/2023 -->
