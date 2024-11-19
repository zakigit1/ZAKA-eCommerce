<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />

  <!-- csrf token for ajax request : -->
  <meta name="csrf-token"  content="{{ csrf_token() }}">

  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <title>
    @yield('title')
  </title>

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
  
   <!-- direction RTL -->
  @if ($settings->layout == "rtl")
    <link rel="stylesheet" href="{{asset('frontend/assets/css/rtl.css')}}">
  @endif 
  
  <!-- Yjra-DataTable Jquery CSS -->
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

  <!-- Yjra-DataTable Jquery Bootsrap5 JS (to fix styling)-->
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">  

  <!-- toastr CSS -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


  <script>
    const USER ={
      id: "{{auth()->user()->id}}",
      name: "{{auth()->user()->name}}",
      image: "{{auth()->user()->image}}",
    }
  </script>

  
</head>

<body>


  <!--=============================
    DASHBOARD MENU START
  ==============================-->
    @include('Frontend.user.Dashboard.layouts.includes.dashboard-manu')
  <!--=============================
    DASHBOARD MENU END
  ==============================-->


  <!--=============================
    DASHBOARD START
  ==============================-->
  <section id="wsus__dashboard">
    <div class="container-fluid">
       <!-- Side Bar-->
       @include('Frontend.user.Dashboard.layouts.includes.sidebar')

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

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Yjra-DataTable Jquery JS -->

  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

  <!-- Yjra-DataTable Jquery Bootsrap5 JS (to fix styling)-->
  
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>


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

  <!--  Dynamic Delete alart  -->
  <script>
    $(document).ready(function() {
      const token = $('meta[name="csrf-token"]').attr('content');
      const deleteUrl = (element) => $(element).attr('href');
    
      $('body').on('click', '.delete-item-with-ajax', function(event) {
        event.preventDefault();
    
        const swalOptions = {
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        };
    
        const deleteThis = this;
    
        Swal.fire(swalOptions).then(result => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'DELETE',
              url: deleteUrl(deleteThis),
              headers: {
                'X-CSRF-TOKEN': token
              },
              success: function(data)  {
                if (data.status == 'success') {
                  Swal.fire(
                    'Deleted!',
                    data.message,
                    'success'
                  ).then(() => {
                    location.reload();
                  });
                }else if(data.status == 'error'){
                  Swal.fire(
                    'Can\'t Deleted !',
                    data.message,
                    'error'
                  )
                }
              },
              error: function(xhr, status, error) {
                console.log(error);
                // Swal.fire(
                //   'Can\'t Deleted !',
                //   data.message,
                //   'error'
                // );
              }
              // success: (data) => {
              //   Swal.fire(
              //     'Deleted!',
              //     data.message,
              //     'success'
              //   ).then(() => {
              //     location.reload();
              //   });
              // },
              // error: function(xhr, status, error) {
              //   // console.log(error);
              //   Swal.fire(
              //     'Can\'t Deleted !',
              //     data.message,
              //     'error'
              //   );
              // }
            });
          }
        });
      });
    });


  </script>

  @stack('scripts')
</body>

</html>