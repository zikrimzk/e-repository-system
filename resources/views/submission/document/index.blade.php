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
                    <h1 class="page-title fw-bold fs-24 mb-0">Document Setting</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">SOP</li>
                                <li class="breadcrumb-item active" aria-current="page">Document Setting</li>
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
                <!-- End Alert-->

                <!-- Start Admin Action -->
                <div class="card custom-card">
                    <div class="card-header">
                        <a class="btn btn-primary-transparent btn-sm me-2" data-bs-toggle="modal"
                            data-bs-target="#modalAdd">Add
                            Document</a>
                    </div>
                </div>
                <!-- End Admin Action -->

                <div class="row mb-5">

                    <!-- Start Modal Add-->
                    <div class="modal fade" id="modalAdd">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Add Document</h6><button aria-label="Close" class="btn-close"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Start Form-->
                                <form action="{{ route('docAddPost') }}" method="POST">
                                    @csrf

                                    <div class="modal-body text-start">
                                        <!-- Doc Name-->
                                        <div class="col-sm-12">
                                            <label for="input-placeholder" class="form-label ">Document Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text"
                                                class="form-control @error('doc_name') is-invalid @enderror" name="doc_name"
                                                id="input-placeholder" placeholder="Activity Name">
                                            @error('doc_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Activity Name-->
                                        <div class="col-sm-12">
                                            <label for="activity" class="form-label">Activity <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" name="activity_id" id="activity">
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
                                        <!-- is Required-->
                                        <div class="col-sm-12">
                                            <label for="isRequired" class="form-label">Required <span
                                                    class="fw-bold">(default Yes)</span></label>
                                            <select class="form-select" name="isRequired" id="isRequired">
                                                <option selected value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <!-- is Show On doc-->
                                        <div class="col-sm-12">
                                            <label for="isShowDoc" class="form-label">Appear in Form <span
                                                    class="text-danger fw-bold">(if any)</span></label>
                                            <select class="form-select" name="isShowDoc" id="isShowDoc">
                                                <option selected value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary-transparent btn-sm">Add
                                            Document</button> <button type="button"
                                            class="btn btn-danger-transparent btn-sm" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                                <!-- End Form-->

                            </div>
                        </div>
                    </div>
                    <!-- End Modal Add -->

                    <!-- Start Modal Update-->
                    @foreach ($docs as $doc)
                        <div class="modal fade" id="modalUpdate{{ $doc->id }}">
                            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Update Document</h6><button aria-label="Close"
                                            class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('docUpdatePost') }}" method="POST">
                                        @csrf
                                        <div class="modal-body text-start">
                                            <!-- Doc Name-->
                                            <div class="col-sm-12">
                                                <label for="docName"
                                                    class="form-label @error('doc_name') is-invalid @enderror">Document
                                                    Name <span class="text-danger fw-bold">*</span></label>
                                                <input type="hidden" name="id" value="{{ $doc->id }}">
                                                <input type="text" class="form-control" name="doc_name"
                                                    id="docName" placeholder="Document Name"
                                                    value="{{ $doc->doc_name }}">
                                                @error('doc_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- Act Name-->
                                            <div class="col-sm-12">
                                                <label for="activity" class="form-label">Activity <span
                                                        class="text-danger fw-bold">*</span></label>
                                                <select class="form-select @error('activity_id') is-invalid @enderror"
                                                    name="activity_id" id="activity">
                                                    <option value="{{ $doc->activity->id }}" selected>
                                                        {{ $doc->activity->act_name }}</option>
                                                    @foreach ($acts as $act)
                                                        @if ($act->id != $doc->activity->id)
                                                            <option value="{{ $act->id }}">{{ $act->act_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('activity_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <!-- is Required-->
                                            <div class="col-sm-12">
                                                <label for="isRequired" class="form-label">Required</label>
                                                <select class="form-select" name="isRequired" id="isRequired">
                                                    @if ($doc->isRequired == 0)
                                                        <option selected value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    @elseif($doc->isRequired == 1)
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <!-- is Show On doc-->
                                            <div class="col-sm-12">
                                                <label for="isShowDoc" class="form-label">Appear in Form <span
                                                        class="text-danger fw-bold">(if any)</span></label>
                                                <select class="form-select" name="isShowDoc" id="isShowDoc">
                                                    @if ($doc->isShowDoc == 0)
                                                        <option selected value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    @elseif($doc->isShowDoc == 1)
                                                        <option selected value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    @endif
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button> <button
                                                type="button" class="btn btn-danger btn-sm"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Modal Update -->

                    <div class="table-responsive">
                        <table class="table text-nowrap data-table" id="responsiveDataTable">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Document Name</th>
                                    <th scope="col">Activity Name</th>
                                    <th scope="col">Required</th>
                                    <th scope="col">Appear in Form</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                            @foreach ($docs as $doc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $doc->doc_name }}</td>
                                    <td>{{ $doc->activity->act_name }}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="" class="btn btn-icon btn-sm btn-info-transparent rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $doc->id }}">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-danger-transparent rounded-pill" type="button" data-bs-toggle="modal" data-bs-target="#alert{{ $doc->id }}"> <i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </td>                
                                </tr>

                
                                <div class="modal" id="alert{{ $doc->id }}">
                                    <div class="modal-dialog bg-transparent border-0 modal-sm">
                                        <div class="modal-content bg-transparent border-0">
                                            <div class="modal-body bg-transparent border-0">
                                                <div class="card bg-white border-0">
                                                    <div class="alert custom-alert1 alert-danger">
                                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x"></i></button>
                                                        <div class="text-center px-5 pb-0">
                                                            <svg class="custom-alert-icon svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"/></svg>
                                                            <h5>danger</h5>
                                                            <p class="">Confirm to delete document ?</p>
                                                            <div class="">
                                                                <form action="{{ route('docDeletePost') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $doc->id }}">
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1">Delete Anyway</button>
                                                                </form>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    

                            @endforeach
                        </tbody> --}}
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
                        ajax: "{{ route('docManagement') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                searchable: false
                            },
                            {
                                data: 'docname',
                                name: 'docname'
                            },
                            {
                                data: 'actname',
                                name: 'actname'
                            },
                            {
                                data: 'required',
                                name: 'required'
                            },
                            {
                                data: 'showdoc',
                                name: 'showdoc'
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
