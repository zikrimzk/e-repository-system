@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Evaluation <small
                            class="fs-12 fw-semibold">({{ $actname }})</small></h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">My Evaluation</li>
                                <li class="breadcrumb-item active">Evaluation
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Error Prompt -->
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
                <!-- Error Prompt Close -->


                <h1 class="page-title fw-bold fs-16 mb-2">Chair</h1>
                <!-- Start Download Form -->
                <div class="card custom-card ">
                    @foreach ($formchair as $f)
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

                <div class="row mb-5">

                    <div class="table-responsive">
                        <table class="table table-nowrap data-table-chair mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Documents</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $d->matricNo }}</th>
                                        <th>{{ $d->prog_code }}</th>
                                        <th>{{ $d->prog_mode }}</th>
                                        <th>{{ $d->name }}</th>
                                        <th>{{ $d->evarole }}</th>
                                        <th>
                                            @if ($d->evastatus == 'Pending')
                                                <span class="badge badge-pill bg-warning">{{ $d->evastatus }}</span>
                                            @elseif($d->evastatus == 'Completed')
                                                <span class="badge badge-pill bg-success">{{ $d->evastatus }}</span>
                                            @endif
                                        </th>
                                        <th>
                                            @if ($d->evadoc == null)
                                                <span class="text-muted">-</span>
                                            @else
                                                <a href="{{ route('evaDown', $d->evaID) }}"
                                                    class="btn btn-sm btn-primary-transparent">Download</a>
                                            @endif
                                        </th>

                                        <th>
                                            @if ($d->evadoc == null)
                                                <button class="btn btn-sm btn-primary-transparent" data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $d->evaID }}">Upload Form</button>
                                            @else
                                                <button class="btn btn-sm btn-primary-transparent" data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $d->evaID }}">Update Form</button>
                                            @endif

                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

                @foreach ($data as $d)
                    <!--Start Modal Upload Chair-->
                    <div class="modal fade" id="uploadModal{{ $d->evaID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form action="{{ route('myevaUploadPost', $d->evaID) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">Upload</h6>
                                        <button type="button" aria-label="Close" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <label for="uploadform" class="form-label">Evaluation Form <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="file" id="file" name="eva_doc" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm ">Submit Form</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Upload Chair -->
                @endforeach

                @foreach ($data2 as $d)
                    <!--Start Modal Upload Examiner-->
                    <div class="modal fade" id="uploadModal{{ $d->evaID }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <form action="{{ route('myevaUploadPost', $d->evaID) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h6 class="modal-title">Upload</h6>
                                        <button type="button" aria-label="Close" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <label for="uploadform" class="form-label">Evaluation Form <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="file" id="file" name="eva_doc" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm ">Submit Form</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!--End Modal Upload Examiner-->
                @endforeach

                <h1 class="page-title fw-bold fs-16 ">Examiner</h1>
                <!-- Start Download Form -->
                <div class="card custom-card ">
                    @foreach ($formexa as $f)
                        <div class="card-header">
                            <a href="{{ route('nomTemplateDown', $f->id) }}" class="btn btn-sm ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" style="fill: rgba(215, 16, 16, 1);transform: ;msFilter:;"
                                    class="align-middle me-2">
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
                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table table-nowrap data-table-examiner mb-2" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Matric No.</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Documents</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data2 as $d)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $d->matricNo }}</th>
                                        <th>{{ $d->prog_code }}</th>
                                        <th>{{ $d->prog_mode }}</th>
                                        <th>{{ $d->name }}</th>
                                        <th>{{ $d->evarole }}</th>
                                        <th>
                                            @if ($d->evastatus == 'Pending')
                                                <span class="badge badge-pill bg-warning">{{ $d->evastatus }}</span>
                                            @elseif($d->evastatus == 'Completed')
                                                <span class="badge badge-pill bg-success">{{ $d->evastatus }}</span>
                                            @endif
                                        </th>
                                        <th>
                                            @if ($d->evadoc == null)
                                                <span class="text-muted">-</span>
                                            @else
                                                <a href="{{ route('evaDown', $d->evaID) }}"
                                                    class="btn btn-sm btn-primary-transparent">Download</a>
                                            @endif
                                        </th>

                                        <th>
                                            @if ($d->evadoc == null)
                                                <button class="btn btn-sm btn-primary-transparent" data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $d->evaID }}">Upload Form</button>
                                            @else
                                                <button class="btn btn-sm btn-primary-transparent" data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $d->evaID }}">Update Form</button>
                                            @endif

                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Content -->




        @include('staff.layouts.footer')
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                let tablechair = new DataTable('.data-table-chair');
                let tableexaminer = new DataTable('.data-table-examiner');


            });
        </script>

    </div>
@endsection
