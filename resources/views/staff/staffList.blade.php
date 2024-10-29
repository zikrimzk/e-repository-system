@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">
                <!-- Start Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Staff Management</h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">Supervision</li>
                            <li class="breadcrumb-item active" aria-current="page">Staff Management</li>
                        </ol>
                    </nav>
                </div>
                <!-- Close Page Header -->

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

                <!-- Admin Action -->
                <div class="card custom-card">
                    <div class="card-header">
                        <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2"
                            href="{{ route('staffAdd') }}">Add Staff</a>
                        <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2"
                            data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalImport">Import Data</a>
                        <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2"
                            href="{{ route('staffListExport') }}">Export Data</a>
                        <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2"
                            href="{{ route('staffExportTemplate') }}">Registration Template</a>

                    </div>
                </div>
                <!-- End Admin Action -->


                <!-- Start Import Modal -->
                <div class="modal fade" id="modalImport">
                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Staff Details</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('staffImport') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="fs-12 fw-bold text-danger">Note</div>
                                    <p class="fs-12 lead">Please make sure to follow the template provided. DO NOT CHANGE
                                        THE HEAD TITLE IN THE TEMPLATE. The file supported in <span class="fw-bold">(*.csv)
                                            or (*.xlsx)</span> only.</p>
                                    <div class="m-3">
                                        <input class="form-control" type="file" name="file" id="file">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Import </button> <button type="button"
                                        class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Import Modal -->

                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Staff ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $(function() {

                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('staffManagement') }}",
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'staffNo',
                                name: 'staffNo' 
                            },
                            {
                                data: 'sname',
                                name: 'sname'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'sphoneNo',
                                name: 'sphoneNo'
                            },
                            {
                                data: 'srole',
                                name: 'srole'
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

        @include('staff.layouts.footer')

    </div>
@endsection
<!-- Done 13/12/2023 -->
