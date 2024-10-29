@extends('staff.layouts.main')


@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Nomination Management</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active" aria-current="page">Nomination</li>
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

                @foreach ($studs as $stud)
                    <!--Start Modal Upload-->
                    <div class="modal fade" id="modalApprove{{ $stud->nomID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form action="{{ route('nominationApproval', $stud->nomID) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">Nomination Approval</h6>
                                        <button type="button" aria-label="Close" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <label for="uploadform" class="form-label">Final Nomination Form <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="file" id="file" name="num_document" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm ">Save Changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Upload-->
                @endforeach


                <div class="row">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Nomination Status</th>
                                    <th scope="col">Document</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>



            </div>
        </div>
        <!-- End::app-content -->

        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {

                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('nominationManagement') }}",
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
                                data: 'actname',
                                name: 'actname'
                            },
                            {
                                data: 'nomstatus',
                                name: 'nomstatus'
                            },
                            {
                                data: 'nomdoc',
                                name: 'nomdoc'
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
