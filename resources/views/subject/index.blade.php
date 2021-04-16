@extends('layouts.app')
@section('content')

<div class="right_col" role="main" style="min-height: 1749px;">
<div class="row">

      @include('components.flash-message')

      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{ucfirst($common)}} List</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="row">
                  <div class="col-sm-12">
                    <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Batch Name</th>

                          <th>Internal 1</th>
                          <th>Internal 2</th>
                          <th>Final Quiz</th>
                          <th>Final Practical</th>
                          <th>Assignment</th>
                          @if(Auth::user()->user_type != '1')
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($subjects as $subject)
                          <tr>
                            <td>{{ucfirst($subject->name)}}</td>
                            <td>{{ucfirst($subject->batch->name)}}</td>
                            <td>{{ucfirst($subject->internal1)}}</td>
                            <td>{{ucfirst($subject->internal2)}}</td>
                            <td>{{ucfirst($subject->finalquiz)}}</td>
                            <td>{{ucfirst($subject->finalpractical)}}</td>
                            <td>{{ucfirst($subject->assignment)}}</td>
                            @if(Auth::user()->user_type != '1')
                            <td class="form-inline">
                              <a href="{{route($common.'.edit',$subject->id)}}" class="btn btn-sm btn-primary">Edit</a>
                              <form onsubmit="return confirm('Do you really want to delete.?');" action="{{route($common.'.destroy',[$subject->id])}}" method="POST">
                                 @method('DELETE')
                                 @csrf
                                 <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </td>
                            @endif
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination">
                      {{ $subjects->links() }}
                    </div>
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