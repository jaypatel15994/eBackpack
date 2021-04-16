@extends('layouts.app')
@section('content')

<div class="right_col" role="main" style="min-height: 1749px;">
  <!-- top tiles -->
      <div class="" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Create {{ucfirst($common)}}</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          @include('components.flash-message')
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>New {{ucfirst($common)}}</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  @if(isset($attendance['id']))
                    <form method="POST" action="{{route($common.'.update',$attendance['id'])}}" id="demo-form2" data-parsley-validate class="form-horizontal 
                    form-label-left">
                    @method('PUT')
                  @else
                    <form method="POST" action="{{route($common.'.store')}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                  @endif
                  @csrf
                  <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Batch Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <select class="form-control batch_id" name="batch_id">
                          <option value="">Select Batch Name</option>
                          @foreach($batches as $batch)
                            <option value="{{$batch['id']}}" @if(isset($attendance['batch_id']) && $attendance['batch_id'] == $batch['id']) selected @endif>{{$batch['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Subject Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <select class="form-control subject_id" name="subject_id">
                          @if(isset($attendance['id']))
                            @foreach($subjects as $subject)
                              <option value="{{$subject['id']}}" @if(isset($attendance['subject_id']) && $attendance['subject_id'] == $subject['id']) selected @endif>{{$subject['name']}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align">Date <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" name="date" value="{{$attendance['date'] ?? ''}}" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                        <script>
                          function timeFunctionLong(input) {
                            setTimeout(function() {
                              input.type = 'text';
                            }, 60000);
                          }
                        </script>
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Student Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 user_id">
                          @if(isset($attendance['id']))
                            @foreach($users as $user)
                            <label class = "checkbox-inline">
                               <input type="checkbox" name="user_id[]" value="{{$user->id}}" @if(isset($attendance['user_id']) && $attendance['user_id'] == $user['id']) checked @endif>{{$user->name}}&nbsp;
                            </label>
                            @endforeach
                          @endif
                      </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                      <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                      </div>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
    <!-- /top tiles -->

    
</div>
@endsection
@push('script')
<script>
  $(document).ready( function() {
    //Check User & Subject Accourding to Batch  
    $("body").on('change','.batch_id' ,function(e) {
      var id = $('option:selected',this).attr('value');
      //Subject
      if(id>0){
        $.ajax({
          url: "{{ route('getSubjectsByBatch') }}",
          type: 'POST',
          context: this,
          data: {
              id: id,
              _token: '{{ csrf_token() }}'
          },
          success: function (data) {
              if(data){
                console.log(data);
                $('.subject_id').html(data);
              }
          }
      });
      //User
      $.ajax({
          url: "{{ route('getUsersByBatchLabel') }}",
          type: 'POST',
          context: this,
          data: {
              id: id,
              _token: '{{ csrf_token() }}'
          },
          success: function (data) {
              if(data){
                console.log(data);
                $('.user_id').html(data);
              }
          }
      });
      }else{
        $('.user_id').html("");
      }
      
    });
  });

</script>
@endpush