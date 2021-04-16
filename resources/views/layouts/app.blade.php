<!DOCTYPE html>
<html lang="en">
  <head>
    @include("layouts.partials.head")
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        @include("layouts.partials.nav")

        <!-- top navigation -->
        @include("layouts.partials.topnav")
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        <!-- /page content -->

        <!-- footer content -->
        @include("layouts.partials.footer")
        <!-- /footer content -->
      </div>
    </div>

    @include("layouts.partials.footermodals")

    @include("layouts.partials.footerscripts")

  </body>
</html>