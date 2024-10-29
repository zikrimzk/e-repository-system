@extends('staff.layouts.main')

@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Department Setting</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Setting</li>
                                <li class="breadcrumb-item active" aria-current="page">Department Setting</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

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
                <!-- End Alert -->


                <!-- Start Admin Action -->
                <div class="card custom-card">
                    <div class="card-header">
                        <a class="btn btn-primary-transparent btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#modalAdd">Add Department</a>
                    </div>
                </div>
                <!-- End Admin Action -->

                <!-- Start Modal Add Department -->
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Add Department</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('depAddPost') }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">

                                    <div class="col-sm-12">
                                        <label for="input-placeholder" class="form-label ">Department Name <span
                                                class="text-danger fw-bold">*</span> </label>
                                        <input type="text" class="form-control" name="dep_name" id="input-placeholder">
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="faculty" class="form-label ">Faculty <span
                                                class="text-danger fw-bold">*</span> </label>
                                        <select name="fac_id" id="faculty" class="form-select">
                                            <option selected disabled>Select</option>
                                            @foreach ($facs as $fac)
                                                <option value="{{ $fac->id }}">{{ $fac->fac_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Add Department</button> <button
                                        type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Add Department -->

                <!-- Start Modal Update Department -->
                @foreach ($deps as $dep)
                    <div class="modal fade" id="modalUpdate{{ $dep->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Update Department</h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('depUpdatePost', $dep->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">

                                        <div class="col-sm-12">
                                            <label for="input-placeholder" class="form-label ">Department Name <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="dep_name"
                                                id="input-placeholder" value="{{ $dep->dep_name }}">
                                        </div>

                                        <div class="col-sm-12">
                                            <label for="faculty" class="form-label ">Faculty <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select name="fac_id" id="faculty" class="form-select">
                                                @foreach ($facs as $fac)
                                                    @if ($fac->id == $dep->fac_id)
                                                        <option value="{{ $fac->id }}" selected>{{ $fac->fac_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $fac->id }}">{{ $fac->fac_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Update Department -->

                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Faculty</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


            </div>
        </div>

        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {

                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('departmentSetting') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'dep_name',
                                name: 'dep_name'
                            },
                            {
                                data: 'facname',
                                name: 'facname'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at'
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
<!-- Done 22/12/2023 -->
