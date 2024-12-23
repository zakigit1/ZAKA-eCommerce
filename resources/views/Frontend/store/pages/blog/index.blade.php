@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." Blogs")

@section('content')


    <!--============================
            BREADCRUMB START
        ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Our Latest Blogs</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:;">Blogs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            BREADCRUMB END
        ==============================-->


    <!--============================
            BLOGS PAGE START
        ==============================-->
    <section id="wsus__blogs">
        <div class="container">
            <div class="row">

                @if (request()->has('search'))
                    <h3><b>Search :</b> <small>{{ request()->search }}</small> </h3>
                    <br><br>
                    <hr>
                @elseif(request()->has('blogCategory'))
                    <h3><b>Search :</b> <small>{{ request()->blogCategory }}</small> </h3>
                    <br><br>
                    <hr>
                @endif



                @if (isset($blogs) && count($blogs) > 0)
                    @foreach ($blogs as $blog)
                        <div class="col-xl-4 col-sm-6 col-lg-4 col-xxl-3">

                            <div class="wsus__single_blog wsus__single_blog_2">
                                <a class="wsus__blog_img" href="{{ route('blog-details', $blog->slug) }}">
                                    <img src="{{ $blog->image }}" alt="blog" class="img-fluid w-100">
                                </a>
                                <div class="wsus__blog_text">
                                    <a class="blog_top red" href="#">{{ $blog->blogcategory->name }}</a>
                                    <div class="wsus__blog_text_center">
                                        <a href="{{ route('blog-details', $blog->slug) }}">{!! limitText($blog->title, 23) !!}</a>
                                        <p class="date">{{ date('M d, Y', strtotime($blog->created_at)) }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>Sorry No Blog(s) Found!</h4>
                        </div>
                    </div>
                @endif

            </div>
            <div id="pagination">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <nav aria-label="Page navigation example">
                            <div class="mt-5">
                                @if ($blogs->hasPages())
                                    {{ $blogs->withQueryString()->links() }}
                                @endif
                            </div>
                        </nav>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!--============================
            BLOGS PAGE END
        ==============================-->








@endsection
