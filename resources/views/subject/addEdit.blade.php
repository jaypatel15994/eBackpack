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
                  @if(isset($subject['id']))
                    <form method="POST" action="{{route($common.'.update',$subject['id'])}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    @method('PUT')
                  @else
                    <form method="POST" action="{{route($common.'.store')}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                  @endif
                  @csrf
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Subject Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="name" id="name" required="required" class="form-control" value="{{$subject['name'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Batch Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <select class="form-control" name="batch_id">
                          @foreach($batches as $batch)
                            <option value="{{$batch['id']}}" @if(isset($subject['batch_id']) && $subject['batch_id'] == $batch['id']) selected @endif>{{$batch['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="internal1">Internal 1 <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="internal1" id="internal1" required="required" class="form-control subjectExamWeightage" value="{{$subject['internal1'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="internal2">Internal 2 <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="internal2" id="internal2" required="required" class="form-control subjectExamWeightage" value="{{$subject['internal2'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="finalquiz">Final Quiz <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="finalquiz" id="finalquiz" required="required" class="form-control subjectExamWeightage" value="{{$subject['finalquiz'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="finalpractical">Final Practical <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="finalpractical" id="finalpractical" required="required" class="form-control subjectExamWeightage" value="{{$subject['finalpractical'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="assignment">Assignment <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="assignment" id="assignment" required="required" class="form-control subjectExamWeightage" value="{{$subject['assignment'] ?? ''}}">
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
  $(document).ready( function() { // Wait until document is fully parsed
  $("#demo-form2").on('submit', function(e){

     e.preventDefault();

     $('#demo-form2').each(function(){
      var totalPoints = 0;
      $('.subjectExamWeightage').each(function(){
        totalPoints += parseInt($(this).val()); //<==== a catch  in here !! read below
      });
      if(totalPoints !=100){
        alert('Value must be equal to 100.');
      }else{
        $("#demo-form2")[0].submit();
      }
    });

  });
})
</script>
@endpush