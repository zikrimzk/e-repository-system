@extends('staff.layouts.main')

@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Add Semester</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Setting</li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="{{ route('semesterManagement') }}">Semester Setting</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Semester</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="card custom-card shadow-lg">
                        <form class="row" method="POST" action="{{ route('semesterPost') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row g-3 mt-0">
                                    <!--Semester Label-->
                                    <div class="col-md-4">
                                        <label for="label" class="form-label">Semester Label <span
                                                class="text-danger fw-bold">*</span> </label>
                                        <input type="text" class="form-control @error('label') is-invalid @enderror"
                                            name="label" id="label" placeholder="Semester Label"
                                            value="{{ old('label') }}">
                                        @error('label')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Semester Status-->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status <span
                                                class="text-dark fw-bold">(default)</span></label>
                                        <input type="text" class="form-control @error('status') is-invalid @enderror"
                                            name="status" id="status" placeholder="Status" value="Inactive" readonly />
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-3 mt-0">
                                    <!--Semester Start Date-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="startdate" class="form-label">Start Date <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                </div>
                                                <input type="date"
                                                    class="form-control @error('startdate') is-invalid @enderror"
                                                    id="startdate" placeholder="Choose date" name="startdate">
                                                @error('startdate')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <!--Semester End Date-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="enddate" class="form-label">End Date <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                </div>
                                                <input type="date"
                                                    class="form-control @error('enddate') is-invalid @enderror"
                                                    id="enddate" placeholder="Choose date" name="enddate">
                                                @error('enddate')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary-transparent btn-sm">Add Semester</button>
                                <a href="{{ route('semesterManagement') }}"
                                    class="btn btn-danger-transparent btn-sm">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @include('Staff.layouts.footer')

    </div>
@endsection
<!-- Done 22/12/2023-->
