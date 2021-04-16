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
                  <div class="col-6">
                    <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($batches as $batch)
                          <tr>
                            <td>{{ucfirst($batch->name)}}</td>
                            <td class="form-inline">
                              <a href="{{route($common.'.edit',$batch->id)}}" class="btn btn-sm btn-primary">Edit</a>
                              <form onsubmit="return confirm('Do you really want to delete.?');" action="{{route($common.'.destroy',[$batch->id])}}" method="POST">
                                 @method('DELETE')
                                 @csrf
                                 <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="pagination">
                      {{ $batches->links() }}
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