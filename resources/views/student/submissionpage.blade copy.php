<?php

use Carbon\Carbon;
?>

@extends('student.layouts.main')
<!-- Prism CSS -->
<link rel="stylesheet" href="../assets/libs/prismjs/themes/prism-coy.min.css">

<link rel="stylesheet" href="../assets/libs/filepond/filepond.min.css">
<link rel="stylesheet" href="../assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
<link rel="stylesheet" href="../assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css">
<link rel="stylesheet" href="../assets/libs/dropzone/dropzone.css">

@section('content')
<div class="page">
   <!-- Start::app-content -->
   <div class="main-content app-content">
       <div class="container-fluid">

           <!-- Page Header -->
           <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
               <h1 class="page-title fw-bold fs-24 mb-0">{{ $sub->doc_name }}</h1>
               <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">{{ Auth::user()->programme->prog_code }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('studentActivity') }}">Activity</a></li>
                <li class="breadcrumb-item"><a href="{{ route('studentEachActivity', $sub->actID) }}">{{ $sub->act_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $sub->doc_name }} Submission</li>
            </ol>
           </div>
           <!-- Page Header Close -->
            <div class="container">
                <!-- Start::row-1 -->
                <div class="row">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Submission Status</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-striped table-hover table-bordered border-primary " >
                                    <tbody>
                                        @if($sub->submission_status == "No Attempt")
                                            <tr style="height:80px">
                                                <th scope="row" class="fw-bold ">Submission Status</th>
                                                <td class=" bg-warning-subtle">{{ $sub->submission_status }}</td>
                                            </tr>
                                            
                                        @elseif($sub->submission_status == "Overdue")
                                            <tr style="height:80px">
                                                <th scope="row" class="fw-bold">Submission Status</th>
                                                <td class=" bg-danger-subtle">{{ $sub->submission_status }}</td>
                                            </tr>
                                        @else
                                            <tr style="height:80px">
                                                <th scope="row" class="fw-bold">Submission Status</th>
                                                <td class=" bg-success-subtle">{{ $sub->submission_status }}</td>
                                            </tr>
                                        @endif
                                        <tr style="height:80px">
                                            <th scope="row" class="fw-bold">Submission Due Date</th>
                                            <td>{{ $date = Carbon::parse($sub->submission_duedate)->format('d M Y , h:i A')}}</td>
                                        </tr>
                                        <tr style="height:80px">
                                            <th scope="row" class="fw-bold">Time Remaining</th>
                                            <td>
                                                {{ $days = Carbon::parse(new DateTime('now'))->diffInDays(Carbon::parse($date)) }} days
                                                {{ $hours = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->diffInHours(Carbon::parse($date)) }} hours
                                                {{ $minutes = Carbon::parse(new DateTime('now'))->copy()->addDays($days)->addHours($hours)->diffInMinutes(Carbon::parse($date))}} minutes
                                            </td>
                                        </tr>
                                        <tr style="height:80px">
                                            <th scope="row" class="fw-bold">File Submission</th>
                                            <td>{{ $sub->submission_doc }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm">Add Submission</button>
                        </div>
                    </div>   
                </div>
                <!--End::row-1 -->

                <!-- Prism Code -->
                <pre class="language-html"><code class="language-html">&lt;div class="mb-3"&gt;
                    &lt;label for="formFile" class="form-label"&gt;Default file input example&lt;/label&gt;
                    &lt;input class="form-control" type="file" id="formFile"&gt;
                &lt;/div&gt;
                &lt;div class="mb-3"&gt;
                    &lt;label for="formFileMultiple" class="form-label"&gt;Multiple files input
                        example&lt;/label&gt;
                    &lt;input class="form-control" type="file" id="formFileMultiple" multiple=""&gt;
                &lt;/div&gt;
                &lt;div class="mb-3"&gt;
                    &lt;label for="formFileDisabled" class="form-label"&gt;Disabled file input
                        example&lt;/label&gt;
                    &lt;input class="form-control" type="file" id="formFileDisabled" disabled=""&gt;
                &lt;/div&gt;
                &lt;div class="mb-3"&gt;
                    &lt;label for="formFileSm" class="form-label"&gt;Small file input example&lt;/label&gt;
                    &lt;input class="form-control form-control-sm" id="formFileSm" type="file"&gt;
                &lt;/div&gt;
                &lt;div&gt;
                    &lt;label for="formFileLg" class="form-label"&gt;Large file input example&lt;/label&gt;
                    &lt;input class="form-control form-control-lg" id="formFileLg" type="file"&gt;
                &lt;/div&gt;</code></pre>
                <!-- Prism Code -->

                <!-- Start::row-2 -->
                <div class="row">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Add Submission</div>
                        </div>
                        <div class="card-body">
                            <input type="file" class="multiple-filepond" name="filepond" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">     
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm">Save Changes</button>
                            <button class="btn btn-danger btn-sm">Cancel</button>

                        </div>
                    </div>   
                </div>
                <!--End::row-2 -->  
            </div>
          

       </div>
   </div>
   <!-- End::app-content -->

   @include('student.layouts.footer')

</div>
@endsection