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
                          <th>Attachment</th>
                          @if(Auth::user()->user_type != '1')
                            <th>Action</th>
                          @endif
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($notices as $notice)
                          <tr>
                            <td>{{ucfirst($notice->name)}}</td>
                            <td>{{ucfirst($notice->batch->name)}}</td>
                            <td><a href="{{ URL::asset($notice->attachment) }}" target="_blank">{{substr($notice->attachment, strrpos($notice->attachment, '/') + 1)}}</a></td>
                            @if(Auth::user()->user_type != '1')
                              <td class="form-inline">
                                <a href="{{route($common.'.edit',$notice->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                <form onsubmit="return confirm('Do you really want to delete.?');" action="{{route($common.'.destroy',[$notice->id])}}" method="POST">
                                   @method('DELETE')
                                   @csrf
                                   <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination">
                      {{ $notices->links() }}
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