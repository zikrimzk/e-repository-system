@extends('staff.layouts.main')


@section('content')
<div class="page">
   
   <div class="main-content app-content">
       <div class="container-fluid">

           <!-- Page Header -->
           <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
               <h1 class="page-title fw-bold fs-24 mb-0">Suggestion System</h1>
               <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('suggestionSystem') }}">Submission</a></li>
                <li class="breadcrumb-item active" aria-current="page">Suggestion System</li>
            </ol>
           </div>
           <!-- Page Header Close -->

           <!-- Alert Section -->
           @if(session()->has('success'))
            <div class="alert alert-secondary alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                <svg class="svg-secondary" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
            </div>
            @endif

            @if(session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
                <svg class="svg-warning" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                    {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
            </div>
            @endif
            <!-- End Alert Section -->

            <!-- Content Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Suggestion</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('suggestList') }}" method="POST" id="suggestedForm">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <select class=" form-select @error('activity_id') is-invalid  @enderror" name="activity_id" id="activity">
                                            <option selected disabled class="fs-14">Select</option>
                                            @foreach($acts as $act)
                                                <option class="fs-14" value="{{ $act->id  }}">{{ $act->act_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('activity_id') 
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 d-flex align-items-center">
                                        <button type="button" id="suggestBtn" class="btn btn-primary btn-sm" >Suggest</button>
                                    </div>
    
                                </div>

                            </form>
                            
                        </div>
                    </div>   
                </div> 
            </div>

            <div class="row result" style="display: none;">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-sm-4 mt-3">
                                    <div class="mb-2 fw-bold fs-12">Student Suggestion List</div>
                                    <select id="list" class="form-select border border-black">
                                    </select>
                                </div>
                                <div class="col-sm-1 d-flex flex-column justify-content-center align-items-center mt-3">
                                    <!-- ISOLATE FORM -->
                                    <form action="{{ route('isolateProcessPost') }}" method="POST" id="isolateForm">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="hidden" id="hiddenID" name="id">
                                            <input type="hidden" id="activityID" name="actID">
                                            <button id="moveright" type="button" class="btn btn-icon btn-primary rounded-pill"><i class='bx bx-chevrons-right'></i></button>
                                        </div>
                                    </form>
                                    <!-- END ISOLATE FORM -->

                                    <!-- REMOVE ISOLATE FORM -->
                                    <form action="{{ route('isolateRemoveProcessPost') }}" method="POST" id="isolateRemoveForm">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="hidden" id="hiddenIsoID" name="id">
                                            <button id="moveleft" type="button"  class="btn btn-icon  btn-primary rounded-pill"><i class='bx bx-chevrons-left'></i></button>
                                        </div>
                                    </form>
                                    <!-- END REMOVE ISOLATE FORM -->
                                </div>
                                
                                <div class="col-sm-4 mt-3 ">
                                    <div class="mb-2 fw-bold fs-12">Isolated Student </div>
                                    <select id="isolate" class="form-select border border-black">
                                    </select>
                                </div>
                                <div class="col-sm-3 mt-3 ">
                                    <div class="mb-2 fw-bold fs-12">Approve & Not Submitted Student </div>
                                    <select id="approved" class="form-select border border-black">
                                    </select>
                                </div>
        
                            </div>
                        
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('suggestionApprovalProcessPost') }}" method="POST">
                                @csrf
                                <input type="hidden" id="actID" name="actID">
                                <button class="btn btn-sm btn-primary">Approve</button>
                            </form>
                            
                        </div>
                    </div>        
                </div>
            </div>
            <!-- End Content Section -->

       </div>
   </div>
   <script>
    //AJAX CODE SEGMENT - SUGGESTION
    $(document).ready(function () { 

        // 1. Isolate Student Code 
        $('#activity').on('change',function(){
            var id = $("#activity")[0].value;
            $('#activityID').val(id);
            $('#actID').val(id);

        });

        $("#moveright").click(function(){
            var id = $("#list")[0].value;
            $('#hiddenID').val(id);
            $("#list > option:selected").each(function(){
                $(this).remove().appendTo("#isolate");
                $('#isolateForm').submit();
                // listStudent();
                isoStudent();
                AcceptedStudent();
               
            });
        });
     
        $('#isolateForm').on('submit',function(e){
            e.preventDefault();
            jQuery.ajax({
                url:'{{ route("isolateProcessPost") }}',
                data:jQuery('#isolateForm').serialize(),
                type:'POST'
            });
        });

        //2. Remove Isolated Student
        $("#moveleft").click(function(){
            $("#isolate > option:selected").each(function(){
                var id = $("#isolate")[0].value;
                $('#hiddenIsoID').val(id);
                    $(this).remove().appendTo("#list");
                    $('#isolateRemoveForm').submit();
                    // listStudent();
                    isoStudent();
                    AcceptedStudent();
            });
        });

        $('#isolateRemoveForm').on('submit',function(e){
            e.preventDefault();
            jQuery.ajax({
                url:'{{ route("isolateRemoveProcessPost") }}',
                data:jQuery('#isolateRemoveForm').serialize(),
                type:'POST',
                success:function(result)
                {
                    
                }
            });
        });

        //3. Suggestion Form
        $('#suggestBtn').on('click',function(){
            $('.result').attr('style','display:block;');
            $('#list').attr('size', 2)
            $('#approved').attr('size', 2)
            $('#isolate').attr('size', 2)
            $('#suggestedForm').submit();
            // listStudent();
            isoStudent();
            AcceptedStudent();
           
           
        });

        $('#suggestedForm').on('submit',function(e){
            e.preventDefault();
            jQuery.ajax({
                url:'{{ route("suggestList") }}',
                data:jQuery('#suggestedForm').serialize(),
                type:'POST',
                success:function(result)
                {
                    var data = result.data;
                    var html = '';
                    var count = 0;
                    var kirasama = 0;
                    var check = '';

                    data.forEach(function(list){ 
                        html += `<option class="fs-12" value="${list.id}">(${list.matricNo})(${list.prog_code}) - ${list.name}</option>`;
                        count = count+1;
                    });
                   
                    if(count < 2)
                    {
                        $('#list').attr('size', 2)

                    }
                    else
                    {
                        $('#list').attr('size', count)
                    }
                    $('#list').html(html);
       
                }
            });
        });

        //4. Function Call
        function isoStudent()
        {
            jQuery.ajax({
                url:'{{ route("isolatedList") }}',
                method:'GET',
                success:function(result)
                {
                    var data = result.data;
                    var html = '';
                    var count = 0;

                    data.forEach(function(iso){
                        if(iso.activities_id ==  $('#activityID').val())
                        {
                            html += `<option class="fs-12" value="${iso.id}">(${iso.matricNo})(${iso.prog_code}) - ${iso.name}</option>`;
                            count = count+1;
                        }
                       
                    })
                    
                   
                    if(count < 2)
                    {
                        $('#isolate').attr('size', 2)
                    }
                    else 
                    {
                        $('#isolate').attr('size', count)
                    }
                    $('#isolate').html(html);


                }
            })
        }

        function AcceptedStudent()
        {
            jQuery.ajax({
                url:'{{ route("AcceptedList") }}',
                method:'GET',
                success:function(result)
                {
                    var data = result.data;
                    var html = '';
                    var count = 0;

                    data.forEach(function(acc){
                        if(acc.activities_id ==  $('#activityID').val())
                        {
                            html += `<option class="fs-12" value="${acc.id}">(${acc.matricNo})(${acc.prog_code}) - ${acc.name}</option>`;
                            count = count+1;
                        }
                    });
                   
                    if(count < 2)
                    {
                        $('#approved').attr('size', 2)
                    }
                    else
                    {
                        $('#approved').attr('size', count)
                    }
                    $('#approved').html(html);


                }
            })
        }
    
       
    });
        // function listStudent()
        // {
        //     jQuery.ajax({
        //         url:'{{ route("suggestList") }}',
        //         method:'POST',
        //         success:function(result)
        //         {
        //             var data = result.data;
        //             var html = '';
        //             var count = 0;
                 
        //             data.forEach(function(list){ 
        //                 html += `<option class="fs-12" value="${list.id}">(${list.matricNo})(${list.prog_code}) - ${list.name}</option>`;
        //                 count = count+1;
        //             });
                   
        //             if(count < 2)
        //             {
        //                 $('#list').attr('size', 2)
        //                 $('#approved').attr('size', 2)

        //             }
        //             else
        //             {
        //                 $('#list').attr('size', count)
        //             }
        //             $('#list').html(html);


        //         }
        //     })
        // }

   </script>

   @include('staff.layouts.footer')

</div>
@endsection

















