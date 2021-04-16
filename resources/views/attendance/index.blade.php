@extends('layouts.app')
@section('content')

<div class="right_col" role="main" style="min-height: 1749px;">
<div class="row">

      @include('components.flash-message')
      <div class="col-md-12 col-sm-12 col-6">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{ucfirst($common)}} List</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                  <div class="col-12">
                    <div class="card-box table-responsive">
                      @if($user_type != 1)
                      <form method="POST" action="{{route('getAttendance')}}" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                  <div class="form-group">
                      <label class="col-form-label col-md-1 col-sm-1 label-align" for="name">Batch Name <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-3 ">
                        <select class="form-control batch_id" name="batch_id">
                          <option value="">Select Batch Name</option>
                          @foreach($batches as $batch)
                            <option value="{{$batch['id']}}" @if(isset($batch_id) && $batch_id == $batch['id']) selected @endif>{{$batch['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                        <div class="form-group">
                      <label class="col-form-label col-md-1 col-sm-1 label-align" for="name">Subject Name <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-3 ">
                        <select class="form-control subject_id" name="subject_id">
                          @foreach($subjects as $subject)
                              <option value="{{$subject['id']}}" @if(isset($subject_id) && $subject_id == $subject['id']) selected @endif>{{$subject['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="item form-group">
                      <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>
                      </form>
                      @endif
                      @if($user_type == 1)
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Batch Name</th>
                          <th>Subject Name</th>
                            <th>Attended</th>
                          <th>Date</th>
                          @if(Auth::user()->user_type != '1')
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($attendances as $attendance)
                          <tr>
                            <td>{{ucfirst($attendance->batch->name ?? '')}}</td>
                            <td>{{ucfirst($attendance->subject->name)}}</td>
                            <td>{{$attendance->attended == 0 ? 'Absent':'Present'}}</td>
                            <td>{{$attendance->date}}</td>
                            @if(Auth::user()->user_type != '1')
                              <!-- <td class="form-inline">
                                <a href="{{route($common.'.edit',$attendance->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                <form onsubmit="return confirm('Do you really want to delete.?');" action="{{route($common.'.destroy',[$attendance->id])}}" method="POST">
                                   @method('DELETE')
                                   @csrf
                                   <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                              </td>
                            </tr> -->
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination">
                      {{ $attendances->links() }}
                    </div>
                    @else
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      {!! $html !!}
                    </table>
                    @endif
                  </div>
                </div>
              </div>
          </div>
      
        <!-- /top tiles -->

      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<script>
  $(document).ready( function() {
    //Check User & Subject Accourding to Batch  
    $("body").on('change','.batch_id' ,function(e) {
      var id = $('option:selected',this).attr('value');
      //Subject
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
    });

  });

</script>
@endpush