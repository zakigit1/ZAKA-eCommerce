@extends('Frontend.store.layouts.master')

@section('title', @$settings->site_name ." Blog Details")

@section('content')

    <!--============================
            BREADCRUMB START
        ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Blog Details</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><a href="{{route('blog')}}">Blogs</a></li>
                            <li><a href="javascript:;">Blog Details</a></li>
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
            BLOGS DETAILS START
        ==============================-->
    <section id="wsus__blog_details">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-8">
                    <div class="wsus__main_blog">
                        <div class="wsus__main_blog_img">
                            <img src="{{ $blog->image }}" alt="blog" class="img-fluid w-100">
                        </div>
                        <p class="wsus__main_blog_header">
                            <span><i class="fas fa-user-tie"></i> {{ $blog->user->name }}</span>
                            <span><i class="fal fa-calendar-alt"></i>
                                {{ date('M d, Y', strtotime($blog->created_at)) }}</span>
                            {{-- <span><i class="fal fa-comment-alt-smile"></i> 0 Comment</span>
                            <span><i class="far fa-eye"></i> 11 Views</span> --}}
                        </p>
                        <div class="wsus__description_area">
                            <h1>{!! $blog->title !!}</h1>
                            {!! $blog->description !!}
                        </div>
                        <div class="wsus__share_blog">
                            <p><b>Share :</b></p>
                            <ul>

                                <li><a class="facebook"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i
                                            class="fab fa-facebook-f"></i></a></li>

                                <li><a class="twitter"
                                        href="https://twitter.com/share?url={{ url()->current() }}&text={{ $blog->title }}via={{ $blog->user->name }}"><i
                                            class="fab fa-twitter"></i></a></li>

                                <li><a class="linkedin"
                                        href="https://www.linkedin.com/shareArticle?url={{ url()->current() }}&title={{ $blog->title }}&summary={{ limitText($blog->description, 23) }}&source=<SOURCE_URL>"><i
                                            class="fab fa-linkedin-in"></i></a></li>

                                {{-- <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li> --}}
                            </ul>
                        </div>

                        {{-- related product --}}
                        @if (isset($related_blogs) && count($related_blogs) > 0)
                            <div class="wsus__related_post">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h5>related post</h5>
                                    </div>
                                </div>
                                <div class="row blog_det_slider">

                                    @foreach ($related_blogs as $related_blog)
                                        <div class="col-xl-3">
                                            <div class="wsus__single_blog wsus__single_blog_2">
                                                <a class="wsus__blog_img"
                                                    href="{{ route('blog-details', $related_blog->slug) }}">
                                                    <img src="{{ $related_blog->image }}" alt="blog"
                                                        class="img-fluid w-100">
                                                </a>
                                                <div class="wsus__blog_text">
                                                    <a class="blog_top red"
                                                        href="#">{{ $related_blog->blogcategory->name }}</a>
                                                    <div class="wsus__blog_text_center">
                                                        <a
                                                            href="{{ route('blog-details', $related_blog->slug) }}">{!! limitText($related_blog->title, 23) !!}</a>
                                                        <p class="date">
                                                            {{ date('M d, Y', strtotime($related_blog->created_at)) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif

                        {{-- Show All Comments ( after i can add delete and edit buttons) --}}

                        <div class="wsus__comment_area">
                            <h4>comment <span>{{ count($comments) }}</span></h4>

                            @if (isset($comments) && $comments->count() > 0)

                                @foreach ($comments as $comment)
                                    <div class="wsus__main_comment">
                                        <div class="wsus__comment_img">
                                            <img src="{{ $comment->user->image }}" alt="user"
                                                style="height:80px; width: 90px;" class="img-fluid">
                                        </div>
                                        <div class="wsus__comment_text replay">
                                            <h6>{{ $comment->user->name }}
                                                <span>{{ date('M d, Y', strtotime($comment->created_at)) }}</span></h6>
                                            <p>{{ $comment->comment }}.</p>

                                            {{-- if you want to replay the comment (You can add it after) you need to add in comment table a parent_id column for replay --}}

                                            {{-- <a href="#" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapsetwo3">replay</a>
                                            <div class="accordion accordion-flush" id="accordionFlushExample3">
                                                <div class="accordion-item">
                                                    <div id="flush-collapsetwo3" class="accordion-collapse collapse"
                                                        aria-labelledby="flush-collapsetwo"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <form>
                                                                <div class="wsus__riv_edit_single text_area">
                                                                    <i class="far fa-edit"></i>
                                                                    <textarea cols="3" rows="1"
                                                                        placeholder="Your Text"></textarea>
                                                                </div>
                                                                <button type="submit" class="common_btn">submit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                        </div>
                                    </div>
                                @endforeach

                                {{-- this is to show the replied comments  --}}
                                {{-- <div class="wsus__main_comment wsus__com_replay">
                                        <div class="wsus__comment_img">
                                            <img src="images/client_img_3.jpg" alt="user" class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__comment_text replay">
                                            <h6>Smith jhon <span>09 Jul 2021</span></h6>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate sint
                                                molestiae eos? Officia, fuga eaque.</p>
                                            <a href="#" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapsetwo2">replay</a>
                                            <div class="accordion accordion-flush" id="accordionFlushExample2">
                                                <div class="accordion-item">
                                                    <div id="flush-collapsetwo2" class="accordion-collapse collapse"
                                                        aria-labelledby="flush-collapsetwo"
                                                        data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <form>
                                                                <div class="wsus__riv_edit_single text_area">
                                                                    <i class="far fa-edit"></i>
                                                                    <textarea cols="3" rows="1"
                                                                        placeholder="Your Text"></textarea>
                                                                </div>
                                                                <button type="submit" class="common_btn">submit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                            @else
                                <div class="card">
                                    <div class="card-body">

                                        <i>no comment yet !</i>

                                    </div>
                                </div>

                            @endif

                            {{-- comment pagination --}}
                            <div id="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">

                                        <nav aria-label="Page navigation example">
                                            <div class="mt-5">
                                                @if ($comments->hasPages())
                                                    {{ $comments->withQueryString()->links() }}
                                                @endif
                                            </div>
                                        </nav>

                                    </ul>
                                </nav>
                            </div>
                        </div>

                        {{-- Add Comment --}}

                        @if (auth()->check())
                            <div class="wsus__post_comment">
                                <h4>post a comment</h4>
                                <form action="{{ route('user.blog-comment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__single_com">
                                                <textarea rows="5" placeholder="Enter Your Comment" name="comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="common_btn" type="submit">post comment</button>
                                </form>
                            </div>
                        @else
                            <div class="wsus__post_comment">

                                <h4> Please login to comment the post !</h4>
                                <a class="common_btn" href="{{ route('login') }}">Login</a>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="col-xxl-3 col-xl-4 col-lg-4">
                    <div class="wsus__blog_sidebar" id="sticky_sidebar">
                        <div class="wsus__blog_search">
                            <h4>search</h4>
                            <form action="{{ route('blog') }}" method="GET">
                                <input type="text" placeholder="Search" name="search">
                                <button type="submit" class="common_btn"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="wsus__blog_category">
                            <h4>Categories</h4>
                            <ul>
                                @if (isset($blogCategories) && count($blogCategories) > 0)
                                    @foreach ($blogCategories as $blogCategory)
                                        <li>
                                            <a href="{{ route('blog', ['blogCategory' => $blogCategory->slug]) }}">
                                                {{ $blogCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                    <li><a href="{{ route('blog') }}">Others</a></li>
                                    {{-- <li><a href="#">Entertainment</a></li>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Lifestyle</a></li>
                                <li><a href="#">Technology</a></li>
                                <li><a href="#">Shoes</a></li>
                                <li><a href="#">electronic</a></li> --}}
                            </ul>
                        </div>

                        <div class="wsus__blog_post">
                            @if (isset($blogs) && count($blogs) > 0)
                                <h4>Recent Post</h4>
                                @foreach ($blogs as $blogItem)
                                    <div class="wsus__blog_post_single">
                                        <a href="{{ route('blog-details', $blogItem->slug) }}" class="wsus__blog_post_img">
                                            <img src="{{ $blogItem->image }}" alt="blog" class="imgofluid w-100">
                                        </a>
                                        <div class="wsus__blog_post_text">
                                            <a
                                                href="{{ route('blog-details', $blogItem->slug) }}">{!! limitText($blogItem->title, 23) !!}</a>
                                            <p> <span>{{ date('M d, Y', strtotime($blogItem->created_at)) }} </span>
                                                {{ count($blogItem->comments) }} Comment </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            BLOGS DETAILS END
        ==============================-->

@endsection
