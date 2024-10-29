@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Supervision Arrangement </h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Supervision</li>
                                <li class="breadcrumb-item active" aria-current="page">Supervision Arrangement
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
                            data-bs-effect="effect-scale" data-bs-target="#modalAdd">Add Supervision</button>
                        {{-- <a class="modal-effect btn btn-primary-transparent btn-sm me-2 disabled"
                            data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalImport">Import Data</a> --}}
                        <a class="modal-effect btn btn-primary-transparent btn-sm me-2"
                            href="{{ route('stustaExport') }}">Export Data</a>

                    </div>
                </div>
                <!-- End Admin Action -->



                <!-- Start Modal Import -->
                {{-- <div class="modal fade" id="modalImport">
                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Supervision</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('stustaImport') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="fs-12 fw-bold text-danger">Note</div>
                                    <p class="fs-12 lead">Please make sure to follow the template provided in the excel
                                        file. The file supported in <span class="fw-bold">(*.csv) or (*.xlsx)</span> only.
                                    </p>

                                    <div class="m-3">
                                        <input class="form-control" type="file" name="file" id="file">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Import </button> <button type="button"
                                        class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <!-- End Modal Import -->

                <!-- Modal Add Supervision -->
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">

                            <div class="modal-header">
                                <h6 class="modal-title">Add Supervision</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('studentSupervisionPost') }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="col-md-12 mb-2">
                                        <label for="studentName" class="form-label">Student Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="student_id" id="studentname">
                                            <option selected disabled>Select</option>
                                            @foreach ($student as $students)
                                                <option value='{{ $students->id }}'> {{ $students->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="svname" class="form-label">Staff Name <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="staff_id" id="svname">
                                            <option selected disabled>Select</option>
                                            @foreach ($staff as $staffs)
                                                <option value='{{ $staffs->id }}'> {{ $staffs->sname }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="customrole" class="form-label">Role <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select" name="supervision_role" id="customrole">
                                            <option selected disabled>Select</option>
                                            <option>Supervisor</option>
                                            <option>Co-Supervisor</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Add Supervision</button> <button
                                        type="button" class="btn btn-danger-transparent btn-sm"
                                        data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>
                            {{-- End Customize Form --}}


                        </div>
                    </div>
                </div>
                <!-- End Modal Add Supervision -->

                <!-- Loop Modal -->
                @foreach ($studentsv as $st)
                    <!-- Start Update Modal -->
                    <div class="modal fade" id="modalUpdate{{ $st->stumatric }}{{ $st->staffID }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">

                                <div class="modal-header">
                                    <h6 class="modal-title">Update Supervision & Evaluation </h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('studentSupervisionUpdatePost') }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">

                                        <div class="col-md-12 mt-2 mb-2">
                                            <label for="studentName" class="form-label">Student Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="hidden"
                                                class="form-control @error('student_id') is-invalid @enderror"
                                                name="student_id" id="studentName" value="{{ $st->studID }}" />
                                            <input type="text" class="form-control" id="studentName"
                                                value="{{ $st->stuname }}" readonly disabled />
                                            @error('student_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="customrole" class="form-label">Role <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="supervision_role" id="customrole">
                                                <option selected>{{ $st->svrole }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <label for="svname" class="form-label">Staff Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="staff_id" id="svname">
                                                <option value='{{ $st->staffID }}'> {{ $st->staname }}</option>
                                                @foreach ($staff as $staffs)
                                                    @if ($staffs->id != $st->staffID)
                                                        <option value='{{ $staffs->id }}'> {{ $staffs->sname }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                                        <button type="button" class="btn btn-danger-transparent btn-sm"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                                {{-- End Customize Form --}}


                            </div>
                        </div>
                    </div>
                    <!-- End Update Modal -->

                    <!-- Title Edit Modal -->
                    <div class="modal fade" id="modalTitleEdit{{ $st->stumatric }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                {{-- Customize Form --}}
                                <form action="{{ route('studentTitleUpdatePost') }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">

                                        {{-- Title (with condition) --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Title Of Research</label>
                                            <input type="hidden" name="id" id="title-hidden"
                                                value="{{ $st->studID }}" />
                                            <input type="text"
                                                class="form-control @error('titleOfResearch') is-invalid @enderror"
                                                name="titleOfResearch" id="title" value="{{ $st->title }}" />
                                            @error('titleOfResearch')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        {{-- End Title (with condition) --}}
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary-transparent btn-sm me-2">Save
                                                changes</button>
                                            <button type="button" class="btn btn-danger-transparent btn-sm"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </form>
                                {{-- End Customize Form --}}


                            </div>
                        </div>
                    </div>
                    <!-- End Title Edit  Modal -->
                @endforeach
                <!-- End loop Modal -->



                <!-- Start::row-1 -->
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
                                    <th scope="col">Title</th>
                                    <th scope="col"></th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Setting</th>

                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <!--End::row-1 -->



            </div>
        </div>
        <!-- End Content -->




        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {

                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('studentSupervision') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'stumatric',
                                name: 'stumatric'
                            },
                            {
                                data: 'code',
                                name: 'code'
                            },
                            {
                                data: 'mode',
                                name: 'mode'
                            },
                            {
                                data: 'stuname',
                                name: 'stuname'
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'btntitle',
                                name: 'btntitle',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'staname',
                                name: 'staname'
                            },

                            {
                                data: 'svrole',
                                name: 'svrole'
                            },
                            // {
                            //     data: 'label',
                            //     name: 'label'
                            // },
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
