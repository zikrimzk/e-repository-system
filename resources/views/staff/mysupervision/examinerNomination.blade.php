@extends('staff.layouts.main')


@section('content')
    <div class="page">
        
        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Nomination <small class="text-dark fw-semibold fs-12">(Supervisor & Co-Supervisor)</small></h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">My Supervision</li>
                                <li class="breadcrumb-item active" aria-current="page">Nomination</li>
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

                <!-- Start Download Form -->
                <div class="card custom-card ">
                    @foreach ($form as $f)
                        <div class="card-header">
                            <a href="{{ route('nomTemplateDown', $f->id) }}" class="btn btn-sm ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    style="fill: rgba(215, 16, 16, 1);transform: ;msFilter:;" class="align-middle me-2">
                                    <path
                                        d="M8.267 14.68c-.184 0-.308.018-.372.036v1.178c.076.018.171.023.302.023.479 0 .774-.242.774-.651 0-.366-.254-.586-.704-.586zm3.487.012c-.2 0-.33.018-.407.036v2.61c.077.018.201.018.313.018.817.006 1.349-.444 1.349-1.396.006-.83-.479-1.268-1.255-1.268z">
                                    </path>
                                    <path
                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM9.498 16.19c-.309.29-.765.42-1.296.42a2.23 2.23 0 0 1-.308-.018v1.426H7v-3.936A7.558 7.558 0 0 1 8.219 14c.557 0 .953.106 1.22.319.254.202.426.533.426.923-.001.392-.131.723-.367.948zm3.807 1.355c-.42.349-1.059.515-1.84.515-.468 0-.799-.03-1.024-.06v-3.917A7.947 7.947 0 0 1 11.66 14c.757 0 1.249.136 1.633.426.415.308.675.799.675 1.504 0 .763-.279 1.29-.663 1.615zM17 14.77h-1.532v.911H16.9v.734h-1.432v1.604h-.906V14.03H17v.74zM14 9h-1V4l5 5h-4z">
                                    </path>
                                </svg>{{ $f->form_name }}
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- End Download Form -->

                @foreach ($studs as $stud)
                    <!--Start Modal Upload-->
                    <div class="modal fade" id="modalUpload-{{ $stud->stuID }}-{{ $stud->actID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form
                                    action="{{ route('mysvUploadNomination', ['stud' => $stud->stuID, 'act' => $stud->actID]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf 
                                    <div class="modal-header">
                                        <h6 class="modal-title">Upload Nomination Form</h6>
                                        <button type="button" aria-label="Close" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <label for="uploadform" class="form-label">Form <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="file" id="file" name="num_document" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger btn-sm ">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Upload-->
                @endforeach

                <div class="row mb-5">
                    <div class="table-responsive table-bordered">
                        <table class="table table-nowrap  data-table mt-2 mb-2 " id="responsiveDataTable">
                            <thead class="table-primary ">
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

        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {

                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('mysvnomination') }}",
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
<!--Done 31/12/2023-->
