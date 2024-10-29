@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">

                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Procedure Setting</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('docManagement') }}">SOP</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Procedure Setting</li>
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
                        <a class="btn btn-primary-transparent btn-sm me-2 " data-bs-toggle="modal"
                            data-bs-target="#modalAdd">Add Procedure</a>
                    </div>
                </div>
                <!-- End Admin Action -->

                <!-- Start Modal Add -->
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <!-- Head -->
                            <div class="modal-header">
                                <h6 class="modal-title">Add Procedure</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Head -->

                            <!-- Start Form -->
                            <form action="{{ route('proAddPost') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <!-- Activity -->
                                    <div class="col-sm-12">
                                        <label for="activity" class="form-label">Activity <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('activities_id') is-invalid  @enderror"
                                            name="activities_id" id="activity">
                                            <option selected disabled>Select</option>
                                            @foreach ($acts as $act)
                                                <option value="{{ $act->id }}">{{ $act->act_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('activities_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Programme -->
                                    <div class="col-sm-12">
                                        <label for="programme" class="form-label">Programme <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('programmes_id') is-invalid  @enderror"
                                            name="programmes_id" id="programme">
                                            <option selected disabled>Select</option>
                                            @foreach ($progs as $prog)
                                                <option value="{{ $prog->id }}">{{ $prog->prog_code }}
                                                    ({{ $prog->prog_mode }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('programmes_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Activity Sequence -->
                                    <div class="col-sm-12">
                                        <label for="act_seq" class="form-label">Activity Sequence<span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="number" name="act_seq"
                                            class="form-control @error('act_seq') is-invalid @enderror" id="act_seq"
                                            value="1" min="1">
                                        @error('act_seq')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Sem Count -->
                                    <div class="col-sm-12">
                                        <label for="semcount" class="form-label">Sem Count <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="number" name="timeline_sem"
                                            class="form-control @error('timeline_sem') is-invalid @enderror" id="semcount"
                                            value="1" min="1">
                                        @error('timeline_sem')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Week Count -->
                                    <div class="col-sm-12">
                                        <label for="countWeek" class="form-label">Week <span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="number" name="timeline_week"
                                            class="form-control @error('timeline_week') is-invalid @enderror"
                                            id="countWeek" value="1" min="1">
                                        @error('timeline_week')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Availibility -->
                                    <div class="col-sm-12">
                                        <label for="status" class="form-label">Initial Status <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('init_status') is-invalid  @enderror"
                                            name="init_status" id="status">
                                            <option selected disabled>Select</option>
                                            <option value="Locked">Locked</option>
                                            <option value="Open">Open Always</option>

                                        </select>
                                        @error('init_status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Evaluation -->
                                    <div class="col-sm-12">
                                        <label for="is_haveEva" class="form-label">Evaluation <span
                                                class="text-dark fw-bold">(default)</span></label>
                                        <select class="form-select @error('is_haveEva') is-invalid  @enderror"
                                            name="is_haveEva" id="is_haveEva">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>

                                        </select>
                                        @error('is_haveEva')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Material -->
                                    <div class="col-sm-12">
                                        <label for="countWeek" class="form-label">Material</label>
                                        <input type="file" name="meterial"
                                            class="form-control @error('meterial') is-invalid @enderror" id="countWeek">
                                        @error('meterial')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary-transparent btn-sm">Add
                                        Procedure</button> <button type="button"
                                        class="btn btn-danger-transparent btn-sm" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                            <!-- End Form -->

                        </div>
                    </div>
                </div>
                <!-- End Modal Add -->

                <!-- Start Modal Update -->
                @foreach ($actdoc as $eva)
                    <div class="modal fade" id="modalUpdate-{{ $eva->activities_id }}-{{ $eva->programmes_id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Update Procedure</h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Start Form -->
                                <form action="{{ route('proUpdatePost') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <input type="hidden" name="activities_id" value="{{ $eva->activities_id }}">
                                        <input type="hidden" name="programmes_id" value="{{ $eva->programmes_id }}">
                                        <!-- Activity -->
                                        <div class="col-sm-12">
                                            <label for="activity" class="form-label">Activity <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-control @error('activities_id') is-invalid  @enderror"
                                                name="activities_id" id="activity" disabled>
                                                <option value="{{ $eva->activities_id }}" selected>{{ $eva->act_name }}
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Programme -->
                                        <div class="col-sm-12">
                                            <label for="programme" class="form-label">Programme</label>
                                            <select class="form-control @error('programmes_id') is-invalid  @enderror"
                                                name="programmes_id" id="programme" disabled>
                                                <option value="{{ $eva->programmes_id }}" selected>
                                                    ({{ $eva->prog_code }})
                                                    - {{ $eva->prog_mode }}</option>
                                            </select>
                                        </div>

                                        <!-- Activity Sequence -->
                                        <div class="col-sm-12">
                                            <label for="act_seq" class="form-label">Activity Sequence<span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="number" name="act_seq"
                                                class="form-control @error('act_seq') is-invalid @enderror"
                                                id="act_seq" value="{{ $eva->actseq }}" min="1">
                                            @error('act_seq')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Sem Count -->
                                        <div class="col-sm-12">
                                            <label for="semcount" class="form-label">Sem Count <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="number" name="timeline_sem"
                                                class="form-control @error('timeline_sem') is-invalid @enderror"
                                                id="semcount" value="{{ $eva->timeline_sem }}" min="1">
                                            @error('timeline_sem')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Week Count -->
                                        <div class="col-sm-12">
                                            <label for="countWeek" class="form-label">Week <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="number" name="timeline_week"
                                                class="form-control @error('timeline_week') is-invalid @enderror"
                                                id="countWeek" value="{{ $eva->timeline_week }}" min="1">
                                            @error('timeline_week')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Availibility -->
                                        <div class="col-sm-12">
                                            <label for="status" class="form-label">Initial Status <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select @error('init_status') is-invalid  @enderror"
                                                name="init_status" id="status">

                                                <option selected>{{ $eva->init_status }}</option>
                                                @if ($eva->init_status == 'Locked')
                                                    <option value="Open">Open Always</option>
                                                @elseif($eva->init_status == 'Open')
                                                    <option value="Locked">Locked</option>
                                                @else
                                                    <option value="Open">Open Always</option>
                                                    <option value="Locked">Locked</option>
                                                @endif

                                            </select>
                                            @error('init_status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Evaluation -->
                                        <div class="col-sm-12">
                                            <label for="is_haveEva" class="form-label">Evaluation</label>
                                            <select class="form-select @error('is_haveEva') is-invalid  @enderror"
                                                name="is_haveEva" id="is_haveEva">
                                                @if ($eva->is_haveEva == '0')
                                                    <option selected value="0">No</option>
                                                    <option value="1">Yes</option>
                                                @elseif($eva->is_haveEva == '1')
                                                    <option value="0">No</option>
                                                    <option selected value="1">Yes</option>
                                                @endif
                                            </select>
                                            @error('is_haveEva')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Material -->
                                        <div class="col-sm-12">
                                            <label for="countWeek" class="form-label">Material</label>
                                            <input type="file" name="meterial"
                                                class="form-control @error('meterial') is-invalid @enderror"
                                                id="file">
                                            <input type="text" class="form-control" value="{{ $eva->material }}">
                                            @error('meterial')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>

                                </form>
                                <!-- End Form -->

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Update -->

                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Activity Name</th>
                                    <th scope="col">Programme</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Sequence</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Week</th>
                                    <th scope="col">Evaluation</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


            </div>
        </div>
        <!-- End Content -->

        @include('staff.layouts.footer')
        <script type="text/javascript">
            $(document).ready(function() {
                $(function() {

                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ route('procedureManagement') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'actname',
                                name: 'actname'
                            },
                            {
                                data: 'progcode',
                                name: 'progcode'
                            },
                            {
                                data: 'progmode',
                                name: 'progmode'
                            },
                            {
                                data: 'actseq',
                                name: 'actseq'
                            },
                            {
                                data: 'sem',
                                name: 'sem'
                            },
                            {
                                data: 'week',
                                name: 'week'
                            },
                            {
                                data: 'hasEva',
                                name: 'hasEva'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'material',
                                name: 'material',
                                searchable: false
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

                // $('#file').on('change',function(){
                //     alert($('#file').val())
                // })


            });
        </script>

    </div>
@endsection
<!-- Done 26/12/2023 -->

