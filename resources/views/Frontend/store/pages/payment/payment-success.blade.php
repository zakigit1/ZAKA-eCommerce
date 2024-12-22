@extends('Frontend.store.layouts.master')

@section('title', "$settings->site_name || Payment Success")

@section('content')

    <!--============================
                BREADCRUMB START
            ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Payment Success</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Payment Success</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                BREADCRUMB END
            ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">

                    <h1><b> Payment Successfully ! </b> </h1>

                </div>
            </div>
        </div>
    </section>

    {{-- <script>
        // Redirect to home after 30 seconds
        setTimeout(function() {
            window.location.href = "{{ route('home') }}";
        }, 30000); // 30000 milliseconds = 30 seconds
    </script> --}}

@endsection

@push('scripts')

    <script>
        // Redirect to home after 30 seconds
        setTimeout(function() {
            window.location.href = "{{ route('home') }}";
        }, 10000); // 30000 milliseconds = 30 seconds
    </script>
    
@endpush


