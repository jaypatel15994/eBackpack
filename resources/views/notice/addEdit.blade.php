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
                  @if(isset($notice['id']))
                    <form method="POST" action="{{route($common.'.update',$notice['id'])}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    @method('PUT')
                  @else
                    <form method="POST" action="{{route($common.'.store')}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                  @endif
                  @csrf
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Notice Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="name" id="name" required="required" class="form-control" value="{{$notice['name'] ?? ''}}">
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Batch Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        <select class="form-control" name="batch_id">
                          @foreach($batches as $batch)
                            <option value="{{$batch['id']}}" @if(isset($notice['batch_id']) && $notice['batch_id'] == $batch['id']) selected @endif>{{$batch['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="item form-group">
                      <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Attachment <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 ">
                        @if(isset($notice['attachment']))
                        Old Attachment: <a href="{{ URL::asset($notice['attachment']) }}" target="_blank">{{substr($notice['attachment'], strrpos($notice->attachment, '/') + 1)}}</a><br><br>
                        @endif
                        <input type="file" name="attachment" class="form-control">
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