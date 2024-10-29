@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Programme Setting</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('programmeManagement') }}">Setting</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Programme Setting</li>
                            </ol>
                        </nav>
                    </div>
                </div>


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
                        <a href="{{ route('programmeAdd') }}" class="btn btn-primary-transparent btn-sm me-2">Add
                            Programme</a>
                    </div>
                </div>
                <!-- End Admin Action -->


                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Faculty</th>
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
                        ajax: "{{ route('programmeManagement') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'prog_name',
                                name: 'prog_name'
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
                                data: 'facname',
                                name: 'facname'
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
<!-- DONE 29/12/2023 -->
