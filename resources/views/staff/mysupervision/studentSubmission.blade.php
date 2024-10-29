@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Submission Management</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">My Supervision</li>
                                <li class="breadcrumb-item">Submission</li>
                                <li class="breadcrumb-item active" aria-current="page">Submission Management</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Loop Modal -->
                @foreach ($sub as $subs)
                    <!-- Start Update Modal -->
                    <div class="modal fade" id="Updatesub{{ $subs->stuID }}{{ $subs->subID }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">

                                <div class="modal-header">
                                    <h6 class="modal-title">Submission Setting</h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('mysvSubUpdate', $subs->subID) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="col-sm-12 mb-2">
                                            <label for="docname" class="form-label">Document</label>
                                            <input type="text" id="docname" class="form-control"
                                                value="{{ $subs->docname }}" readonly disabled />
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <label for="duedate" class="form-label">Due Date</label>
                                            <input type="datetime-local" id="duedate" class="form-control" name="duedate"
                                                value="{{ $subs->subduedate }}" />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary-transparent btn-sm">Save
                                            changes</button>
                                        <button type="button" class="btn btn-danger-transparent btn-sm"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                                {{-- End Customize Form --}}


                            </div>
                        </div>
                    </div>
                    <!-- End Update Modal -->
                @endforeach
                <!-- End loop Modal -->


                <div class="row mb-5">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
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
                        ajax: "{{ route('mysvsubmissionManagement') }}",
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
                                data: 'docname',
                                name: 'docname'
                            },
                            {
                                data: 'subduedate',
                                name: 'subduedate'
                            },
                            {
                                data: 'substatus',
                                name: 'substatus'
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
<!--Done 31/12/2023-->