@extends('staff.layouts.main')

@section('content')
    <div class="page">

        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">My Student</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">My Supervision</li>
                                <li class="breadcrumb-item active" aria-current="page">My Student</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Start Admin Action -->
                <div class="card custom-card">
                    <div class="card-header">
                        <a class="modal-effect btn btn-primary-transparent btn-sm me-2 "
                            href="{{ route('mysvlistExport') }}">Export Data</a>
                    </div>
                </div>
                <!-- End Admin Action -->

                
                <div class="row mb-5">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone No.</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Research Title</th>
                                    <th scope="col">My Role</th>
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
                        ajax: "{{ route('mysvstudentlist') }}",
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
                                data: 'sem',
                                name: 'sem'
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'svrole',
                                name: 'svrole'
                            },
                            
                        ]
    
    
    
                    });
    
                  
    
    
                });
    
    
            });
        </script>

    </div>
@endsection
<!-- Done 31/12/2023-->
