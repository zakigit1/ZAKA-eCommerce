<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <title>One Shop || e-Commerce HTML Template</title>
  <link rel="icon" type="image/png" href="{{asset('frontend/assets/images/favicon.png')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/slick.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.nice-number.min.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.calendar.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/add_row_custon.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/mobile_menu.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.exzoom.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/multiple-image-video.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/ranger_style.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.classycountdown.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/venobox.min.css')}}">

  <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">
  <!-- <link rel="stylesheet" href="css/rtl.css"> -->

      <!-- toastr CSS -->
  
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>


  <!--=============================
    DASHBOARD MENU START
  ==============================-->
    @include('vendor.Dashboard.layouts.includes.dashboard-manu')
  <!--=============================
    DASHBOARD MENU END
  ==============================-->


  <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
       <!-- Side Bar-->
       @include('vendor.Dashboard.layouts.includes.sidebar')

        @yield('content')
    </div>
  </section>
  <!--=============================
    DASHBOARD START
  ==============================-->


  <!--============================
      SCROLL BUTTON START
    ==============================-->
  <div class="wsus__scroll_btn">
    <i class="fas fa-chevron-up"></i>
  </div>
  <!--============================
    SCROLL BUTTON  END
  ==============================-->


  <!--jquery library js-->
  <script src="{{asset('frontend/assets/js/jquery-3.6.0.min.js')}}"></script>
  <!--bootstrap js-->
  <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
  <!--font-awesome js-->
  <script src="{{asset('frontend/assets/js/Font-Awesome.js')}}"></script>
  <!--select2 js-->
  <script src="{{asset('frontend/assets/js/select2.min.js')}}"></script>
  <!--slick slider js-->
  <script src="{{asset('frontend/assets/js/slick.min.js')}}"></script>
  <!--simplyCountdown js-->
  <script src="{{asset('frontend/assets/js/simplyCountdown.js')}}"></script>
  <!--product zoomer js-->
  <script src="{{asset('frontend/assets/js/jquery.exzoom.js')}}"></script>
  <!--nice-number js-->
  <script src="{{asset('frontend/assets/js/jquery.nice-number.min.js')}}"></script>
  <!--counter js-->
  <script src="{{asset('frontend/assets/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('frontend/assets/js/jquery.countup.min.js')}}"></script>
  <!--add row js-->
  <script src="{{asset('frontend/assets/js/add_row_custon.js')}}"></script>
  <!--multiple-image-video js-->
  <script src="{{asset('frontend/assets/js/multiple-image-video.js')}}"></script>
  <!--sticky sidebar js-->
  <script src="{{asset('frontend/assets/js/sticky_sidebar.js')}}"></script>
  <!--price ranger js-->
  <script src="{{asset('frontend/assets/js/ranger_jquery-ui.min.js')}}"></script>
  <script src="{{asset('frontend/assets/js/ranger_slider.js')}}"></script>
  <!--isotope js-->
  <script src="{{asset('frontend/assets/js/isotope.pkgd.min.js')}}"></script>
  <!--venobox js-->
  <script src="{{asset('frontend/assets/js/venobox.min.js')}}"></script>
  <!--classycountdown js-->
  <script src="{{asset('frontend/assets/js/jquery.classycountdown.js')}}"></script>

  <!--main/custom js-->
  <script src="{{asset('frontend/assets/js/main.js')}}"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <script>

    @if($errors->any())

    @foreach($errors->all() as $error)
    
      //  without CDN :
      // <?php 
      //   toastr()->error($error);
      // ?>

      //  with CDN :

      // -> this is norml  :
      // toastr.error('{{ $error }}');

      // -> this is custom :
      toastr.error('{{ $error }}','Error',{
        closeButton:true,
        progressBar:true
      });

    @endforeach


    @endif
  </script>
</body>

</html>