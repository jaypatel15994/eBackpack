<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('/')}}" class="site_title"><i class="fa fa-university"></i> <span>eBackpack</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  @if(Auth::user()->user_type != '1')
                  <li><a><i class="fa fa-graduation-cap"></i> Batches <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('batches.create')}}">Add Batch</a></li>
                      <li><a href="{{route('batches.index')}}">Batches</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-group"></i> Students <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('student.create')}}">Add Student</a></li>
                      <li><a href="{{route('student.index')}}">Students</a></li>
                    </ul>
                  </li>
                  @endif

                  <li><a><i class="fa fa-book"></i> Subjects <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if(Auth::user()->user_type != '1')
                        <li><a href="{{route('subject.create')}}">Add subject</a></li>
                      @endif
                      <li><a href="{{route('subject.index')}}">Subjects</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-calculator"></i> Results <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if(Auth::user()->user_type != '1')
                        <li><a href="{{route('result.create')}}">Add result</a></li>
                      @endif
                      <li><a href="{{route('result.index')}}">Results</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-check-square-o"></i> Attendances <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if(Auth::user()->user_type != '1')
                        <li><a href="{{route('attendance.create')}}">Add attendance</a></li>
                      @endif
                      <li><a href="{{route('attendance.index')}}">Attendances</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-bell"></i> Notices <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if(Auth::user()->user_type != '1')
                        <li><a href="{{route('notice.create')}}">Add Notice</a></li>
                      @endif
                      <li><a href="{{route('notice.index')}}">Notices</a></li>
                    </ul>
                  </li>

                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

          </div>
        </div>