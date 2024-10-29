<?php

use Carbon\Carbon;
?>

@extends('staff.layouts.main')

@section('content')
    <div class="page">
        <!-- Start Content -->
        <div class="main-content app-content">
            <div class="container">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-bold fs-24 mb-0">Form Setting</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">SOP</li>
                                <li class="breadcrumb-item">Activity</li>
                                <li class="breadcrumb-item active" aria-current="page">Form Setting</li>
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

                <!-- Start Admin Button -->
                <div class="card custom-card">
                    <div class="card-header">
                        <a class="btn btn-primary-transparent btn-sm me-2 " data-bs-toggle="modal"
                            data-bs-target="#modalAdd">Add Form</a>
                    </div>
                </div>
                <!-- End Admin Button -->

                <!-- Start Modal Add -->
                <div class="modal fade" id="modalAdd">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content modal-content-demo">
                            <!-- Head -->
                            <div class="modal-header">
                                <h6 class="modal-title">Add Form</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Head -->

                            <!-- Start Form -->
                            <form action="{{ route('formAddPost') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">

                                    <!-- Form Name -->
                                    <div class="col-sm-12">
                                        <label for="form_name" class="form-label">Form Name<span
                                                class="text-danger fw-bold">*</span></label>
                                        <input type="text" name="form_name"
                                            class="form-control @error('form_name') is-invalid @enderror" id="form_name"
                                            value={{ old('form_name') }}>
                                        @error('form_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Documents -->
                                    <div class="col-sm-12">
                                        <label for="form_doc" class="form-label">Form Document <small>(only *.doc)</small>
                                            <span class="text-danger fw-bold">*</span></label>
                                        <input type="file" name="form_doc"
                                            class="form-control @error('form_doc') is-invalid @enderror" id="form_doc">
                                        @error('form_doc')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Activity -->
                                    <div class="col-sm-12">
                                        <label for="activity" class="form-label">Activity <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('activity_id') is-invalid  @enderror"
                                            name="activity_id" id="activity">
                                            <option selected disabled>Select</option>
                                            @foreach ($acts as $act)
                                                <option value="{{ $act->id }}">{{ $act->act_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('activity_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Appearance -->
                                    <div class="col-sm-12">
                                        <label for="form_appearance" class="form-label">Form Appearance <span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('form_appearance') is-invalid  @enderror"
                                            name="form_appearance" id="form_appearance">
                                            <option selected disabled>Select</option>
                                            <option value="AS">Submission</option>
                                            <option value="NOM">Nomination</option>
                                            <option value="EvaChair">Evaluation - Chair</option>
                                            <option value="EvaExa">Evaluation - Examiner</option>


                                        </select>
                                        @error('form_appearance')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Is Show -->
                                    <div class="col-sm-12">
                                        <label for="form_isShow" class="form-label">Show<span
                                                class="text-danger fw-bold">*</span></label>
                                        <select class="form-select @error('form_isShow') is-invalid  @enderror"
                                            name="form_isShow" id="form_isShow">
                                            <option selected disabled>Select</option>
                                            <option value="1">Show</option>
                                            <option value="0">Hidden</option>
                                        </select>
                                        @error('form_isShow')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>



                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button> <button
                                        type="button" class="btn btn-danger btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                            <!-- End Form -->

                        </div>
                    </div>
                </div>
                <!-- End Modal Add -->

                <!-- Start Modal Update -->
                @foreach ($forms as $form)
                    <div class="modal fade" id="modalupdate{{ $form->formID }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content modal-content-demo">
                                <!-- Head -->
                                <div class="modal-header">
                                    <h6 class="modal-title">Update Form</h6><button aria-label="Close" class="btn-close"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Head -->

                                <!-- Start Form -->
                                <form action="{{ route('formUpdatePost', $form->formID) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body text-start">

                                        <!-- Form Name -->
                                        <div class="col-sm-12">
                                            <label for="form_name" class="form-label">Form Name<span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" name="form_name"
                                                class="form-control @error('form_name') is-invalid @enderror"
                                                id="form_name" value="{{ $form->fname }}">
                                            @error('form_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Documents -->
                                        <div class="col-sm-12">
                                            <label for="form_doc" class="form-label">Form Document <small>(only
                                                    *.doc)</small> <span class="text-danger fw-bold">*</span></label>
                                            <input type="file" name="form_doc"
                                                class="form-control @error('form_doc') is-invalid @enderror"
                                                id="form_doc_up">
                                            <input type="text" name="form_doc_val" class="form-control"
                                                id="form_doc_val" value="{{ $form->fdoc }}">
                                        </div>

                                        <!-- Activity -->
                                        <div class="col-sm-12">
                                            <label for="activity" class="form-label">Activity <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select @error('activity_id') is-invalid  @enderror"
                                                name="activity_id" id="activity">
                                                <option selected value="{{ $form->actID }}">{{ $form->act_name }}
                                                </option>
                                                @foreach ($acts as $act)
                                                    @if ($act->id != $form->actID)
                                                        <option value="{{ $act->id }}">{{ $act->act_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('activity_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Appearance -->
                                        <div class="col-sm-12">
                                            <label for="form_appearance" class="form-label">Form Appearance <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select @error('form_appearance') is-invalid  @enderror"
                                                name="form_appearance" id="form_appearance">
                                                @if ($form->fappearance == 'AS')
                                                    <option selected value="AS">After Submission</option>
                                                    <option value="NOM">Nomination</option>
                                                    <option value="EvaChair">Evaluation - Chair</option>
                                                    <option value="EvaExa">Evaluation - Examiner</option>
                                                @elseif($form->fappearance == 'NOM')
                                                    <option value="AS">After Submission</option>
                                                    <option value="NOM" selected>Nomination</option>
                                                    <option value="EvaChair">Evaluation - Chair</option>
                                                    <option value="EvaExa">Evaluation - Examiner</option>
                                                @elseif($form->fappearance == 'EvaChair')
                                                    <option value="AS">After Submission</option>
                                                    <option value="NOM">Nomination</option>
                                                    <option value="EvaChair" selected>Evaluation - Chair</option>
                                                    <option value="EvaExa">Evaluation - Examiner</option>
                                                @elseif($form->fappearance == 'EvaExa')
                                                    <option value="AS">After Submission</option>
                                                    <option value="NOM">Nomination</option>
                                                    <option value="EvaChair">Evaluation - Chair</option>
                                                    <option value="EvaExa" selected>Evaluation - Examiner</option>
                                                @endif
                                            </select>
                                            @error('form_appearance')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Is Show -->
                                        <div class="col-sm-12">
                                            <label for="form_isShow" class="form-label">Show<span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select @error('form_isShow') is-invalid  @enderror"
                                                name="form_isShow" id="form_isShow">
                                                @if ($form->isShow == '1')
                                                    <option selected value="1">Show</option>
                                                    <option value="0">Hidden</option>
                                                @elseif($form->isShow == '0')
                                                    <option selected value="0">Hidden</option>
                                                    <option value="1">Show</option>
                                                @endif
                                            </select>
                                            @error('form_isShow')
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


                <!-- Start::row-1 -->
                <div class="row mb-5">
                    <div class="table-responsive">
                        <table class="table text-nowrap data-table" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Form Name</th>
                                    <th scope="col">Form Documents</th>
                                    <th scope="col">Appearance</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--End::row-1 -->

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
                        ajax: "{{ route('formSetting') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'fname',
                                name: 'fname'
                            },
                            {
                                data: 'fdoc',
                                name: 'fdoc'
                            },
                            {
                                data: 'fappearance',
                                name: 'fappearance'
                            },
                            {
                                data: 'act_name',
                                name: 'act_name'
                            },
                            {
                                data: 'isShow',
                                name: 'isShow'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]


                    });



                    // $('#filter-prog').change(function(){
                    //     table.column($(this).data('column'))
                    //     .search($('#filter-prog').val())
                    //     .draw();
                    // });

                    $('#DataTables_Table_0_filter input').attr('class', ' form-control');
                    $('#DataTables_Table_0_filter input').attr('placeholder', 'Search here ....');


                });
                $('#form_doc_up').on('change', function() {
                    $('#form_doc_val').val($('#form_doc_up').val());
                })


            });
        </script>

    </div>
@endsection
