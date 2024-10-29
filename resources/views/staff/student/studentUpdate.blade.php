@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">
                <!--Start Page Header-->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Update Student details</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Supervision</li>
                                <li class="breadcrumb-item"><a href="{{ route('staffManagement') }}">Student Management</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Update Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--End Page Header-->

                <div class="row">
                    <div class="card custom-card">
                        <div class="card-body">
                            <form class="row" method="POST" action="{{ route('studentUpdatePost') }}" id="update">
                                @csrf
                                <div class="row g-3 mt-0">
                                    <!--Full Name-->
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror bg-light" name="name"
                                            id="name" value="{{ $students->name }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Email-->
                                    <div class="col-md-4">
                                        <label for="studentDetail" class="form-label">Email</label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror bg-light"
                                            name="email" id="studentDetail" value="{{ $students->email }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Phone No-->
                                    <div class="col-md-4">
                                        <label for="phoneNo" class="form-label">Phone No.</label>
                                        <input type="text"
                                            class="form-control @error('phoneNo') is-invalid @enderror bg-light"
                                            name="phoneNo" id="phoneNo"placeholder="Phone Number"
                                            value="{{ $students->phoneNo }}">
                                        @error('phoneNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Gender-->
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror bg-light"
                                            name="gender" id="gender">
                                            <option selected>{{ $students->gender }}</option>
                                            @if ($students->gender == 'Male')
                                                <option>Female</option>
                                            @else
                                                <option>Male</option>
                                            @endif
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Status-->
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select @error('status') is-invalid @enderror bg-light"
                                            name="status" id="status">
                                            <option selected>{{ $students->status }}</option>
                                            @if ($students->status == 'Active')
                                                <option>Inactive</option>
                                            @else
                                                <option>Active</option>
                                            @endif
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Address-->
                                    <div class="col-md-4">
                                        <label for="address" class="form-label">Address <small>(optional)</small></label>
                                        <input type="text"
                                            class="form-control @error('address') is-invalid @enderror bg-light"
                                            name="address" id="address" value="">
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Matric No-->
                                    <div class="col-md-3">
                                        <label for="matricNo" class="form-label">Matric No.</label>
                                        <input type="text"
                                            class="form-control @error('matricNo') is-invalid @enderror bg-light"
                                            name="matricNo" id="matricNo" placeholder="Matric No."
                                            value="{{ $students->matricNo }}" readonly/>
                                        @error('matricNo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Semester-->
                                    <div class="col-md-3">
                                        <label for="sem_name" class="form-label">Semester</label>
                                        <input type="text" class="form-control bg-light"
                                            id="sem_name"placeholder="Phone Number"
                                            value="{{ $students->semester->label }}" readonly />
                                    </div>
                                    <!--Programme-->
                                    <div class="col-md-3">
                                        <label for="programme_id" class="form-label">Programme</label>
                                        <select class="form-select @error('programme_id') is-invalid @enderror bg-light"
                                            name="programme_id" id="programme_id">
                                            <option selected value="{{ $students->programme_id }}">
                                                {{ $students->programme->prog_code }}
                                                ({{ $students->programme->prog_mode }})</option>
                                            @foreach ($progs as $prog)
                                                @if ($prog->id != $students->programme_id)
                                                    <option value="{{ $prog->id }}">{{ $prog->prog_code }}
                                                        ({{ $prog->prog_mode }})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('programme_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!--Role-->
                                    <div class="col-md-3">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control bg-light" name="role" id="role"
                                            placeholder="Phone Number" value="Student" readonly />
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary-transparent btn-sm"
                                id="submit">Save Changes</button>
                            <a href="{{ route('studentManagement') }}"
                                class="btn btn-danger-transparent btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#submit').on('click', function() {
                    $('#update').submit();
                });
            });
        </script>

        @include('staff.layouts.footer')

    </div>
@endsection
<!-- Done 5/12/2023 -->
