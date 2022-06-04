<!DOCTYPE html>
<html lang="en">

<head>

   @include('include.front_end_head')
</head>

<body>
    <!-- header -->
    <div>
      
        @include('include.header')
   
    </div>
     <!--End- header -->

        <!-- sidebar -->
    <div>
      
        @include('include.sidebar')
    </div>
    <!--End- sidebar -->
         @yield('content');
        @yield('page_javascript');
    </div>
    <div class="sidebar-overlay" data-reff=""></div>

    <div>
       @include('include.main_end_script')

    </div>
   
</body>




</html>