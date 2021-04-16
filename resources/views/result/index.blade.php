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
                          <th>Batch Name</th>
                          <th>Subject Name</th>
                          <th>Student Name</th>
                          <th>Internal 1</th>
                          <th>Internal 2</th>
                          <th>Final Quiz</th>
                          <th>Final Practical</th>
                          <th>Assignment</th>
                          <th>Total</th>
                          @if(Auth::user()->user_type != '1')
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($results as $result)
                          <tr>
                            <td>{{ucfirst($result->batch->name ?? '')}}</td>
                            <td>{{ucfirst($result->subject->name)}}</td>
                            <td>{{ucfirst($result->user->name ?? '')}}</td>
                            <td>{{ucfirst($result->internal1)}}</td>
                            <td>{{ucfirst($result->internal2)}}</td>
                            <td>{{ucfirst($result->finalquiz)}}</td>
                            <td>{{ucfirst($result->finalpractical)}}</td>
                            <td>{{ucfirst($result->assignment)}}</td>
                            <td>{{ucfirst($result->total)}}</td>
                            @if(Auth::user()->user_type != '1')
                            <td class="form-inline">
                              <a href="{{route($common.'.edit',$result->id)}}" class="btn btn-sm btn-primary">Edit</a>
                              <form onsubmit="return confirm('Do you really want to delete.?');" action="{{route($common.'.destroy',[$result->id])}}" method="POST">
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
                      {{ $results->links() }}
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