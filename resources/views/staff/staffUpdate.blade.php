@extends('staff.layouts.main')

@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <!--Start Page Header-->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Update Staff Details</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Supervision</li>
                                <li class="breadcrumb-item"><a href="{{ route('staffManagement') }}">Staff Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page"></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--End Page Header-->

                <div class="row">
                    <div class="card custom-card shadow-lg">
                        <form class="row" method="POST" action="{{ route('staffUpdatePost') }}">
                            @csrf
                            <div class="card-body">

                                <div class="row g-3 mt-0">
                                    <!-- Full Name -->
                                    <div class="col-md-4">
                                        <label for="staffName" class="form-label">Full Name <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text" class="form-control @error('sname') is-invalid @enderror bg-light"
                                            name="sname" id="staffName" placeholder="First name"
                                            value="{{ $staff->sname }}">
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
                                        <input type="email" class="form-control @error('email') is-invalid @enderror bg-light"
                                            name="email" id="staffEmail" placeholder="UTem Email"
                                            value="{{ $staff->email }}">
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
                                        <input type="text" class="form-control @error('sphoneNo') is-invalid @enderror bg-light"
                                            name="sphoneNo" id="staffphoneNo"placeholder="Phone Number"
                                            value="{{ $staff->sphoneNo }}">
                                        @error('sphone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Staff No. -->
                                    <div class="col-md-4">
                                        <label for="staffNo" class="form-label">Staff No. <span
                                                class="fw-bold text-danger">*</span></label>
                                        <input type="text" class="form-control @error('staffNo') is-invalid @enderror bg-light"
                                            name="staffNo" id="staffNo" placeholder="Staff ID"
                                            value="{{ $staff->staffNo }}" readonly />
                                        @error('staffNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Department -->
                                    <div class="col-md-4">
                                        <label for="staffDepartment" class="form-label">Department <span
                                                class="fw-bold text-danger">*</span></label>
                                        <select class="form-select @error('dep_id') is-invalid @enderror bg-light"
                                            name="dep_id" id="staffDepartment">
                                            @foreach($depts as $dept)
                                                @if($dept->id == $staff->dep_id)
                                                    <option value="{{ $staff->dep_id }}" selected>{{ $dept->dep_name }}</option>
                                                @else 
                                                    <option value="{{ $dept->id }}" >{{ $dept->dep_name }}</option>
                                                @endif
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
                                        <select class="form-select @error('srole') is-invalid @enderror bg-light" name="srole"
                                            id="staffRole">
                                            <option selected>{{ $staff->srole }}</option>
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
                                   
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary-transparent btn-sm">Save Changes</button>
                                <a href="{{ route('staffManagement') }}"
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
<!--Done 13/12/2023-->
<!--Done Update Department 23/12/2023-->
