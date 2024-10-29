@extends('staff.layouts.main')

@section('content')
    <!-- Chartjs Chart JS -->
    <script src="../assets/libs/chart.js/chart.min.js"></script>
    <style type="text/css" media="print">
        body {
            visibility: hidden;
        }

        .no-print {
            visibility: hidden;
            dsiplay:none;
        } 

        .print {
            visibility: visible;
        }
    </style>
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">
                @if (Auth::guard('staff')->user()->srole != 'Timbalan Dekan Pendidikan')
                    <!--Start Page Header -->
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <h1 class="page-title fw-bold fs-24 mb-0">Student Management</h1>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('studentManagement') }}">Supervision</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Student Management</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Page Header Close -->
                @else
                    <!--Start Page Header -->
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <h1 class="page-title fw-bold fs-24 mb-0">Student List</h1>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('studentManagement') }}">Student</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Student List</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Page Header Close -->
                @endif

                <!--Start Alert -->
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
                <!--End Alert -->
                

                <!--Admin Action -->
                <div class="card custom-card no-print">
                    <div class="card-header">
                        @if (Auth::guard('staff')->user()->srole != 'Timbalan Dekan Pendidikan')
                            <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print"
                                href="{{ route('studentAdd') }}">Add Student</a>
                            <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print"
                                data-bs-effect="effect-scale" data-bs-toggle="modal" href="#modalImport">Import Data</a>
                            <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print"
                                href="{{ route('studentExport') }}">Export Data</a>
                            <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print"
                                href="{{ route('studentExportTemplate') }}">Registration Template</a>
                        @else
                            <a class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print"
                                href="{{ route('studentExport') }}">Export Data</a>
                        @endif
                        {{-- <button class="modal-effect btn btn-primary-transparent btn-sm d-grid mb-2 me-2 no-print" onclick="window.print();return false;">
                            Print
                        </button> --}}
                        
                    </div>
                </div>
                <!-- End Admin Action -->


                <!-- Import prompt modal -->
                <div class="modal fade" id="modalImport">
                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Student Details</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('studentImport') }}" method="POST" enctype="multipart/form-data">
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
                                    <button type="submit" class="btn btn-primary">Import </button> <button type="button"
                                        class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Import prompt modal -->

                <div class="row mb-5 ">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2 print" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Setting</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        @include('staff.layouts.footer')

    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            $(function() {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('studentManagement') }}",
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phoneNo',
                            name: 'phoneNo'
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
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'sem',
                            name: 'sem'
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

            /* pie chart */
            const data2 = {
                labels: [
                    'Active',
                    'Inactive',
                    'snsnns'
                ],
                datasets: [{
                    label: 'Programme Dataset',
                    data: [300, 50,33],
                    backgroundColor: [
                        'rgb(132, 90, 223)',
                        'rgb(35, 183, 229)',
                        'rgb(31, 100, 24)'

                    ],
                    hoverOffset: 4
                }]
            };
            const config3 = {
                type: 'pie',
                data: data2,
            };
            const myChart2 = new Chart(
                document.getElementById('chartjs-pie'),
                config3
            );


        });
    </script>
@endsection
<!-- Done 13/12/2023 -->
