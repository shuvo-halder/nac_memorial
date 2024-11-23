@extends('frontend.master')

@section('content')
    <section id="memorial_artical">
        <div class="bg">
            <div class="container">

                @if (session('success'))
                    <div id="floating-alert" class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <div class="row gy-4">
                    <div class="col-md-3">
                        <div class="animal-details">
                            <a class="add-memory" href="{{ route('insert.obituary') }}">
                                <i class="fas fa-plus"></i>
                                <span class="ms-1">Add my Memorial</span>
                            </a>
                            <div class="image">
                                <img src="{{ asset($item->getThumb()) }}" alt="Details">
                                <div class="image-overlay">
                                    <a href="{{ asset($item->getThumb()) }}" data-lightbox="example-1"
                                        data-title="{{ $item->title }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="text">
                                <h3>{{ Str::limit($item->title, 15, '...') }}</h3>
                                <a href="{{ route('profile', [$item->user->id, $item->user->name]) }}"
                                    class="text-secondary py-2 pt-1"><i class="fas fa-user me-1"></i>
                                    {{ Str::of($item->user->name)->explode(' ')->last() }}</a>

                                <p>{{ $item->category->name }} <span style="font-size: 18px">
                                        @if ($item->details->sex == 'male')
                                            <i class="fas fa-mars" style="color: #ADD8E6"></i>
                                        @else
                                            <i class="fas fa-venus" style="color: #FFB6C1"></i>
                                        @endif
                                    </span>
                                    <span><i class="far fa-eye"></i> {{ $item->views->count() }}</span>
                                </p>

                                <div class="date-section">
                                    <div class="birth d-flex gap-2 align-items-center">
                                        <div class="icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="date">
                                            <p class="m-0">Date of birth
                                                <span>{{ Carbon\Carbon::create($item->details->birth_date)->format('d M, Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dead d-flex gap-2 align-items-center pt-3">
                                        <div class="icon">
                                            <img style=" width: 20px;"
                                                src="{{ asset('assets/frontend/images/grave.svg') }}" alt="">
                                        </div>
                                        <div class="date">
                                            <p class="m-0">Date of dead
                                                <span>{{ Carbon\Carbon::create($item->details->death_date)->format('d M, Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="social">
                                    <a href="#" style="--icon-color: #3b5998;"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" style="--icon-color: #e4405f;"><i class="fab fa-instagram"></i></a>
                                    <a href="#" style="--icon-color: #1da1f2;"><i class="fab fa-twitter"></i></a>
                                    <a href="#" style="--icon-color: #0077b5;"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" style="--icon-color: #25D366;"><i class="fab fa-whatsapp"></i></a>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="blog-paragraph">
                            <div class="heading2">
                                <h3> {{ $item->title }}
                                    ({{ Carbon\Carbon::create($item->details->birth_date)->diffInYears() }} Years Old)</h3>
                            </div>
                            <div class="paragraph">
                                {!! $item->description !!}
                            </div>
                        </div>



                        @if ($item->additionalImages->count() > 0 && $item->additionalImages->count() < 3)
                            <div class="row">
                                <div class=" col-md-12">


                                    <div class="blog-images p-4">
                                        <div class="row">
                                            @foreach ($item->additionalImages as $image)
                                                <div class="col-md-6">
                                                    <div class="blog-images-container">
                                                        <img src="{{ asset('img/obituary/' . $item->id . '/additional/' . $image->filename) }}"
                                                            alt="Details">
                                                        <div class="image-overlay">
                                                            <a href="{{ asset('img/obituary/' . $item->id . '/additional/' . $image->filename) }}"
                                                                data-lightbox="e-1" data-title="{{ $item->title }}">
                                                                <i class="fas fa-search"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if ($item->additionalImages->count() > 2)
                            <div class="blog-images">
                                <div class="blog-images-slider">
                                    @foreach ($item->additionalImages as $image)
                                        <div class="blog-images-container">
                                            <img src="{{ asset('img/obituary/' . $item->id . '/additional/' . $image->filename) }}"
                                                alt="Details">
                                            <div class="image-overlay">
                                                <a href="{{ asset('img/obituary/' . $item->id . '/additional/' . $image->filename) }}"
                                                    data-lightbox="e-1" data-title="{{ $item->title }}">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif



                        <div class="row">
                            <div class="col-md-12">
                                <div class="comment">
                                    @auth
                                        <form id="commentForm" action="{{ route('comments.store', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="content" required
                                                    class="form-control comment-input"
                                                    placeholder="Write your comment here..." id="commentInput">
                                            </div>
                                            <button type="submit" style="background: #fbe8d2;" class="btn btn-sm mt-2">
                                                <i class="fas fa-paper-plane"></i> Send
                                            </button>
                                        </form>
                                    @endauth

                                    @guest
                                        <p>
                                            Create an <a style="color: #fd8c99;" href="{{ route('register') }}">account</a>
                                            or
                                            <a style="color: #fd8c99;" href="{{ route('login') }}">login</a> to comment.
                                        </p>
                                    @endguest

                                    <div class="user-comment">
                                        <h4>Comments</h4>

                                        <div id="comments-container">
                                            @forelse($comments as $comment)
                                                <div class="comment-box">
                                                    <div class="comment-user d-flex align-items-center">
                                                        <div class="author-image me-2">
                                                            <a class="text-dark"
                                                                href="{{ route('profile', [$comment->user->id, $comment->user->name]) }}">
                                                                <img src="{{ asset($comment->user->getAvatar()) }}"
                                                                    alt="user">
                                                            </a>
                                                        </div>
                                                        <div class="author">
                                                            <p class="m-0">
                                                                <a class="text-dark"
                                                                    href="{{ route('profile', [$comment->user->id, $comment->user->name]) }}">
                                                                    {{ $comment->user->name }}
                                                                </a>
                                                                <span
                                                                    class="m-0">{{ $comment->created_at->diffForHumans() }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="comment-message">
                                                        <p>{{ $comment->content }}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <p>No comments yet.</p>
                                            @endforelse
                                        </div>

                                        @if (count($comments) >= 5)
                                            <button id="loadMoreComments" class="btn btn-sm" style="background: #fbe8d2;"
                                                data-offset="5"><i class="fas fa-arrow-down"></i> Load
                                                More</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </section>
@endsection
