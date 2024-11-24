<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <!-- csrf token for ajax request : -->
  <meta name="csrf-token"  content="{{ csrf_token() }}">


  <title>
    @yield('title')
  </title>

  <link rel="icon" type="image/png" href="{{$logoSettings->favicon}}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('backend/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/modules/weather-icon/css/weather-icons.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/modules/summernote/summernote-bs4.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/css/components.css')}}">
  {{-- this is for RTL  --}}
  
  @if ($settings->layout == "rtl")
    <link rel="stylesheet" href="{{asset('backend/assets/css/rtl.css')}}">
  @endif 
  
  <!-- toastr CSS -->
  
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  
  <!-- Yjra-DataTable Jquery CSS -->
  
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
  
  <!-- Yjra-DataTable Jquery Bootsrap5 JS (to fix styling)-->
  
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
  {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}

  <!-- Bootstrap Icon Piker CSS -->
  <link rel="stylesheet" href="{{asset('backend/assets/css/bootstrap-iconpicker.min.css')}}"/>
  
  <!-- Bootstrap date Piker CSS -->
  <link rel="stylesheet" href="{{asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
  
  <!-- Bootstrap class select2 CSS -->
  
  <link rel="stylesheet" href="{{asset('backend/assets/modules/select2/dist/css/select2.min.css')}}">


  <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-94034622-3');
    </script>
  <!-- /END GA -->

  {{-- Grap user (Admin) information :  --}}
  <script>
    const USER ={
      id: "{{auth()->user()->id}}",
      name: "{{auth()->user()->name}}",
      image: "{{auth()->user()->image}}",
    }
  </script>

    {{-- Pusher (realtime) --}}
    @vite(['resources/js/app.js','resources/js/admin.js'])
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
        @include('Admin.Dashboard.layouts.includes.navbar')
        @include('Admin.Dashboard.layouts.includes.sidebar')


      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>

      <!-- Footer -->
        @include('Admin.Dashboard.layouts.includes.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('backend/assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/popper.js')}}"></script>
  <script src="{{asset('backend/assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/chart.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('backend/assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- Page Specific JS File -->
  {{-- <script src="{{asset('backend/assets/js/page/index-0.js')}}"></script> --}}
  
  <!-- Template JS File -->
  <script src="{{asset('backend/assets/js/scripts.js')}}"></script>
  <script src="{{asset('backend/assets/js/custom.js')}}"></script>
  
  <!-- toastr JS -->
  
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <!-- Yjra-DataTable Jquery JS -->
  
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
  
  <!-- Yjra-DataTable Jquery Bootsrap5 JS (to fix styling)-->
  
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
  {{-- <script src="//cdn.datatables.net/2.0.8/js/dataTables.js"></script> --}}
  {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Bootstrap Icon Piker JS -->
  
  <script type="text/javascript" src="{{asset('backend/assets/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
  
  <!-- Bootstrap date Piker JS -->
  <script src="{{asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

  <!-- Bootstrap class select2 JS -->
  <script src="{{asset('backend/assets/modules/select2/dist/js/select2.full.min.js')}}"></script>




<!--  Display error validation   -->
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