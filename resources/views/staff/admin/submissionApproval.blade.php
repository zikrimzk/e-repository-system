@extends('staff.layouts.main')


@section('content')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <style>
        .kbw-signature {
            width: 200px;
            height: 100px;
        }
    </style>
    <div class="page">
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Submission Approval</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">Student</li>
                                <li class="breadcrumb-item active" aria-current="page">Submission Approval</li>
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


                <div class="row">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>


                <span style="display: none">
                    {{ $i = 0 }}
                </span>
                @foreach ($subs as $sub)
                    <!--Modal Accept-->
                    <div class="modal fade" id="modalAccept-{{ $sub->actID }}{{ $sub->stuID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form
                                    action="{{ route('adminApproveSubmission', ['act' => $sub->actID, 'stud' => $sub->stuID]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{ $sub->actname }} Approval
                                            <small>({{ $sub->name }})</small> </h6><button type="button"
                                            aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p class="text-dark mb-1 fw-bold">Note</p>
                                        <p class="text-muted mb-0">Please carefully review the submission before proceeding.
                                            Confirm that all required documents and information are correctly followed by
                                            student.</p>
                                        <p class="text-muted mt-1">In the space provided below, please affix your digital
                                            <span class="fw-bold text-dark">signature</span> to officially approve this
                                            submission.</p>
                                        <div class="d-flex justify-content-center">
                                            <div id="sig{{ $loop->iteration }}"></div>
                                            <textarea id="signature64{{ $loop->iteration }}" name="signed" style="display:none"></textarea>
                                        </div> 

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="clear{{ $loop->iteration }}"
                                            class="btn btn-danger-transparent btn-sm">Clear
                                            Signature</button>
                                        <button type="submit" class="btn btn-primary btn-sm ">Approve</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Accept-->

                    <!--Start Modal Reject-->
                    <div class="modal fade" id="modalReject-{{ $sub->actID }}{{ $sub->stuID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form
                                    action="{{ route('mysvRejectSubmission', ['stuact' => $sub->stuactID,'staff'=>auth()->user()->id] ) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{ $sub->actname }} Rejection
                                            <small>({{ $sub->name }})</small> </h6><button type="button"
                                            aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p class="text-dark mb-1 fw-bold">Note</p>
                                        <p class="text-muted mb-0">Please carefully review the submission before rejection. 
                                            Give a comment to students to make change of their submissions.</p>
                                        <p class="text-muted mb-3">(<span class="text-danger fw-bold">*</span>) is required</p>
                                        <label for="" class="form-label">Comment <span class="text-danger fw-bold">*</span></label>
                                        <textarea name="r_comment" class="form-control" cols="10" rows="3"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger btn-sm ">Confirm Rejection</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Reject-->

                    <span style="display: none">
                        {{ $i++ }}
                    </span>
                @endforeach
                <input type="hidden" id="loop" value="{{ $i }}">


            </div>
        </div>
        <!-- End::app-content -->

        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {
                let s = $('#loop').val();
               

                for (let i = 1; i <= parseInt(s); i++) {
                    $('#sig'+i).signature({
                        syncField: '#signature64'+i,
                        syncFormat: 'PNG'
                    });
                    $('#clear'+i).click(function(e) {
                        e.preventDefault();
                        $('#sig'+i).signature({
                        syncField: '#signature64'+i,
                        syncFormat: 'PNG'
                        }).signature('clear');
                        $("#signature64"+i).val('');
                    });
            
                }
               
               

                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('adminsubmissionApproval') }}",
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
                                data: 'finaldoc',
                                name: 'finaldoc'
                            },
                            {
                                data: 'finalstatus',
                                name: 'finalstatus'
                            },
                            {
                                data: 'sname',
                                name: 'sname'
                            },
                            {
                                data: 'studentdate',
                                name: 'studentdate'
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
