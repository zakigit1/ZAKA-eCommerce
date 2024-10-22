<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
        
        <meta name="csrf-token"  content="{{ csrf_token() }}">


        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet">


        <title>
            @yield('title')
        </title>


        <link rel="icon" type="image/png" href="{{$logoSettings->favicon}}">
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
        
        @if ($settings->layout == "rtl")
            <link rel="stylesheet" href="{{asset('frontend/assets/css/rtl.css')}}"> 
        @endif

        <!-- toastr CSS -->
    
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    </head>

    <body>

        <!--============================
            HEADER START
        ==============================-->


        @include('Frontend.store.layouts.includes.header')
        <!--============================
            HEADER END
        ==============================-->


        <!--============================
            MAIN MENU START
        ==============================-->

        @include('Frontend.store.layouts.includes.menu.main-menu')
        <!--============================
            MAIN MENU END
            ==============================-->
            
            

        <!--============================
            MOBILE MENU START
        ==============================-->

        @include('Frontend.store.layouts.includes.menu.mobile-menu')
        <!--============================
            MOBILE MENU END
        ==============================-->


        <!--==========================
            POP UP START
        ===========================-->
        <!-- <section id="wsus__pop_up">
            <div class="wsus__pop_up_center">
                <div class="wsus__pop_up_text">
                    <span id="cross"><i class="fas fa-times"></i></span>
                    <h5>get up to <span>75% off</span></h5>
                    <h2>Sign up to E-SHOP</h2>
                    <p>Subscribe to the <b>E-SHOP</b> market newsletter to receive updates on special offers.</p>
                    <form>
                        <input type="email" placeholder="Your Email" class="news_input">
                        <button type="submit" class="common_btn">go</button>
                        <div class="wsus__pop_up_check_box">
                        </div>
                    </form>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11">
                        <label class="form-check-label" for="flexCheckDefault11">
                            Don't show this popup again
                        </label>
                    </div>
                </div>
            </div>
        </section> -->
        <!--==========================
            POP UP END
        ===========================-->


        <!--==========================
            Main-content  START
        ===========================-->

            @yield('content')

        <!--==========================
            Main-content  END
        ===========================-->


        <!--============================
            FOOTER PART START
        ==============================-->
            @include('Frontend.store.layouts.includes.footer')
        <!--============================
            FOOTER PART END
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



        <!-- toastr JS -->
    
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    



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

                    }

                    });
                }
                });
            });
            });


        </script>

        <script>
            $(document).ready(function() {
                $('.auto_click').click();
            });
        </script>

        @include('Frontend.store.layouts.includes.scripts')


    @stack('scripts')
    </body>

</html>