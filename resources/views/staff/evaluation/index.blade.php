@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Evaluation Arrangement</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active">Evaluation Arrangement
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Error Prompt -->
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
                <!-- Error Prompt Close -->

                <!-- Start Admin Action -->
                <div class="card custom-card">
                    <div class="card-header">
                        <button class="modal-effect btn btn-sm btn-primary-transparent me-2" data-bs-toggle="modal"
                            data-bs-effect="effect-scale" data-bs-target="#modalAdd">Add Evaluator</button>
                    </div>
                </div>
                <!-- End Admin Action -->

                <!-- Modal Add Evaluator -->
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">

                            <div class="modal-header">
                                <h6 class="modal-title">Add Evaluator </h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('evaPost') }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <!-- Evaluator Activity -->
                                    <div class="col-md-12 mb-2">
                                        <label for="activity_id" class="form-label">Evaluation Activity <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="activity_id" id="activity_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($activity as $act)
                                                <option value='{{ $act->actID }}'> {{ $act->actname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Student Name -->
                                    <div class="col-md-12 mb-2">
                                        <label for="student_id" class="form-label">Student Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="student_id" id="student_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($student as $students)
                                                <option value='{{ $students->stuID }}'> {{ $students->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Staff Name -->
                                    <div class="col-md-12 mb-2">
                                        <label for="staff_id" class="form-label">Staff Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="staff_id" id="staff_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($staff as $staffs)
                                                <option value='{{ $staffs->id }}'> {{ $staffs->sname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-12 mb-2">
                                        <label for="customrole" class="form-label">Role <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="eva_role" id="customrole">
                                            <option selected disabled>Select</option>
                                            <option value="Chair">Chair (Supervisor/ Co-Supervisor)</option>
                                            <option>Examiner 1</option>
                                            <option>Examiner 2</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button> <button
                                        type="button" class="btn btn-danger-transparent btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Add Evaluator -->

                 <!-- Modal Update Evaluator -->
                @foreach ($eva as $e)
                    <div class="modal fade" id="modalUpdate{{ $e->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">

                                <div class="modal-header">
                                    <h6 class="modal-title">Update Evaluator </h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('evaUpdatePost',$e->id ) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">

                                        <!-- Evaluator Activity -->
                                        <div class="col-md-12 mb-2">
                                            <label for="activity_id" class="form-label">Evaluation Activity <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="activity_id" id="activity_id">
                                                @foreach ($activity as $act)
                                                    @if ($act->actID == $e->activity_id)
                                                        <option value='{{ $act->actID }}' selected> {{ $act->actname }}
                                                        </option>
                                                    @else
                                                        <option value='{{ $act->actID }}'> {{ $act->actname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Student Name -->
                                        <div class="col-md-12 mb-2">
                                            <label for="student_id" class="form-label">Student Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="student_id" id="student_id">
                                                <option selected disabled>Select</option>
                                                @foreach ($student as $students)
                                                    @if ($students->stuID == $e->student_id)
                                                        <option value='{{ $students->stuID }}' selected> {{ $students->name }}
                                                    @else
                                                        <option value='{{ $students->stuID }}'> {{ $students->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Staff Name -->
                                        <div class="col-md-12 mb-2">
                                            <label for="staff_id" class="form-label">Staff Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="staff_id" id="staff_id">
                                                @foreach ($staff as $staffs)
                                                @if ($staffs->id == $e->staff_id)
                                                    <option value='{{ $staffs->id }}' selected> {{ $staffs->sname }}</option>
                                                @else
                                                    <option value='{{ $staffs->id }}'> {{ $staffs->sname }}</option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Role -->
                                        <div class="col-md-12 mb-2">
                                            <label for="customrole" class="form-label">Role <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="eva_role" id="customrole">
                                                @if($e->eva_role == 'Examiner 1')
                                                    <option value="Chair">Chair (Supervisor/ Co-Supervisor)</option>
                                                    <option selected>Examiner 1</option>
                                                    <option>Examiner 2</option>

                                                @elseif($e->eva_role == 'Examiner 2')
                                                    <option value="Chair">Chair (Supervisor/ Co-Supervisor)</option>
                                                    <option>Examiner 1</option>
                                                    <option selected>Examiner 2</option>
                                                @elseif($e->eva_role == 'Chair')
                                                    <option value="Chair" selected>Chair (Supervisor/ Co-Supervisor)</option>
                                                    <option>Examiner 1</option>
                                                    <option>Examiner 2</option>
                                                @endif
                                                
                                              
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                        <button type="button" class="btn btn-danger-transparent btn-sm"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Modal Update Evaluator -->

                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Examiner</th>
                                    <th scope="col">Role</th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Content -->




        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {
                $(function() {
                    var id = $('#actID').val();
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: '{{ route('evaluationArragement') }}',
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'matricNo',
                                name: 'matricNo'
                            },
                            {
                                data: 'prog_code',
                                name: 'prog_code'
                            },
                            {
                                data: 'prog_mode',
                                name: 'prog_mode'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'actname',
                                name: 'actname'
                            },

                            {
                                data: 'sname',
                                name: 'sname'
                            },
                            {
                                data: 'evarole',
                                name: 'evarole'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });
                });


            });
        </script>

    </div>
@endsection
