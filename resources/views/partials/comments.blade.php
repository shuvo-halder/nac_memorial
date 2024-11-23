@foreach ($comments as $comment)
    <div class="comment-box">
        <div class="comment-user d-flex align-items-center">
            <div class="author-image me-2">
                <a class="text-dark" href="{{ route('profile', [$comment->user->id, $comment->user->name]) }}">
                    <img src="{{ asset($comment->user->getAvatar()) }}" alt="user">
                </a>
            </div>
            <div class="author">
                <p class="m-0">
                    <a class="text-dark" href="{{ route('profile', [$comment->user->id, $comment->user->name]) }}">
                        {{ $comment->user->name }}
                    </a>
                    <span class="m-0">{{ $comment->created_at->diffForHumans() }}</span>
                </p>
            </div>
        </div>
        <div class="comment-message">
            <p>{{ $comment->content }}</p>
        </div>
    </div>
@endforeach
