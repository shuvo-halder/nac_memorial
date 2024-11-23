@extends('frontend.master')

@section('content')
    <section id="blog_artical">
        <div class="bg">
            <div class="container">

                @if (session('success'))
                    <div id="floating-alert" class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="heading">
                    <div class="row">
                        <div class="col-1 col-md-2  d-flex align-items-center">
                            <div class="back_button">
                                <a href="{{ route('blog.posts.view') }}"><i class="fas fa-arrow-left"></i>
                                    <span class="d-none d-lg-inline">Back</span></a>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="blog-heading">
                                <h3 class="m-0">{!! $post->title !!}</h3>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <!-- Make the col-md-3 appear first on mobile by setting order-first -->
                    <div class="col-md-3 order-first order-md-2">
                        <div class="blog-image-container-padding">
                            <div class="blog-image-container">
                                <img src="{{ asset($post->getThumbnail()) }}" class="w-100">

                                <div class="image-overlay">
                                    <a href="{{ asset($post->getThumbnail()) }}" data-lightbox="example-1"
                                        data-title="{{ $post->title }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="category d-none d-lg-block">
                            <h3>Categories</h3>
                            <ul>
                                @foreach ($blogCategories as $category)
                                    <li>
                                        <a
                                            href="{{ route('blog.categories.show', $category->slug) }}">{{ $category->name }}</a><span>{{ $category->posts_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Make the col-md-9 appear second on mobile by setting order-last -->
                    <div class="col-md-9 order-last order-md-1">
                        <div class="blog-paragraph">
                            <div class="heading2">
                                <h3>{{ $post->description }}</h3>
                            </div>
                            <div class="paragraph">
                                {!! $post->body !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="comment">
                                    @auth
                                        <form id="commentForm" action="{{ route('blog.comments.store', $post->slug) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="comment" required class="form-control comment-input"
                                                    placeholder="Write your comment here..." id="commentInput">
                                            </div>

                                            <button type="submit" style="background: #fbe8d2;" class="btn btn-sm mt-2">
                                                <i class="fas fa-paper-plane"></i> Send
                                            </button>
                                        </form>
                                    @endauth

                                    @guest
                                        <p>
                                            Create an <a style="color: #fd8c99;" href="{{ route('register') }}">account</a> or
                                            <a style="color: #fd8c99;" href="{{ route('login') }}">login</a> to comment
                                        </p>
                                    @endguest

                                    <div class="user-comment">
                                        <h4>Comment</h4>

                                        <div class="comments">
                                            @forelse($comments as $comment)
                                                <div class="comment-box">
                                                    <div class="comment-user d-flex align-items-center ">
                                                        <div class="author-image me-2">
                                                            <a class="text-dark"
                                                                href="{{ route('profile', [$comment->commentedBy->id, $comment->commentedBy->name]) }}">
                                                                <img src="{{ asset($comment->commentedBy->getAvatar()) }}"
                                                                    alt="user"></a>
                                                        </div>
                                                        <div class="author">
                                                            <p class="m-0">
                                                                <a class="text-dark"
                                                                    href="{{ route('profile', [$comment->commentedBy->id, $comment->commentedBy->name]) }}">
                                                                    {{ $comment->commentedBy->name }}</a>
                                                                <span
                                                                    class="m-0">{{ $comment->created_at->diffForHumans() }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="comment-message">
                                                        <p>{!! $comment->comment !!}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
@endsection
