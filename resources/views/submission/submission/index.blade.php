@extends('staff.layouts.main')


@section('content')
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Submission Management</h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">Submission</li>
                            <li class="breadcrumb-item active" aria-current="page">Submission Management</li>
                        </ol>
                    </nav>
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
                        <a href="{{ route('refreshSubmission') }}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                <path
                                    d="M10 11H7.101l.001-.009a4.956 4.956 0 0 1 .752-1.787 5.054 5.054 0 0 1 2.2-1.811c.302-.128.617-.226.938-.291a5.078 5.078 0 0 1 2.018 0 4.978 4.978 0 0 1 2.525 1.361l1.416-1.412a7.036 7.036 0 0 0-2.224-1.501 6.921 6.921 0 0 0-1.315-.408 7.079 7.079 0 0 0-2.819 0 6.94 6.94 0 0 0-1.316.409 7.04 7.04 0 0 0-3.08 2.534 6.978 6.978 0 0 0-1.054 2.505c-.028.135-.043.273-.063.41H2l4 4 4-4zm4 2h2.899l-.001.008a4.976 4.976 0 0 1-2.103 3.138 4.943 4.943 0 0 1-1.787.752 5.073 5.073 0 0 1-2.017 0 4.956 4.956 0 0 1-1.787-.752 5.072 5.072 0 0 1-.74-.61L7.05 16.95a7.032 7.032 0 0 0 2.225 1.5c.424.18.867.317 1.315.408a7.07 7.07 0 0 0 2.818 0 7.031 7.031 0 0 0 4.395-2.945 6.974 6.974 0 0 0 1.053-2.503c.027-.135.043-.273.063-.41H22l-4-4-4 4z">
                                </path>
                            </svg>
                            Re-assign Submission
                        </a>
                    </div>
                </div>
                <!-- End Admin Action -->

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

                                <form action="{{ route('subUpdate', $subs->subID) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="col-sm-12 mb-2">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name" class="form-control"
                                                value="{{ $subs->name }}" readonly disabled />
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <label for="docname" class="form-label">Document</label>
                                            <input type="text" id="docname" class="form-control"
                                                value="{{ $subs->docname }}" readonly disabled />
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="submission_status" id="status" class="form-select">
                                                <option>{{ $subs->substatus }}</option>
                                                @if ($subs->substatus == 'Locked')
                                                    <option value="No Attempt">Open</option>
                                                @elseif($subs->substatus == 'No Attempt' || $subs->substatus == 'Overdue')
                                                    <option value="Locked">Locked</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <label for="duedate" class="form-label">Due Date</label>
                                            <input type="datetime-local" id="duedate" class="form-control"
                                                name="submission_duedate" value="{{ $subs->subduedate }}" />
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

                <div class="row">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


                {{-- <div class="row">
                    <form action="{{ route('subtest') }}" method="POST">
                        @csrf
                        <div class="col-sm-4">
                            <input type="text" name='name' class="form-control">
                            <button class="btn btn-sm btn-primary">Send Mail</button>
                        </div>
                        
                    </form>
                </div> --}}

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
                        ajax: "{{ route('submissionAllManagement') }}",
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
                                data: 'code',
                                name: 'code'
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
