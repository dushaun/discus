<div id="reply-{{$reply->id}}" class="card mb-3">
    <div class="card-header">
        <div class="level">
            <div class="flex">
                <a href="{{ route('profile', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </div>

            <div>
                <form method="post" action="/replies/{{ $reply->id }}/likes">
                    {{ csrf_field() }}

                    <button class="btn btn-link btn-sm" type="submit" {{ $reply->isLiked() ? 'disabled' : '' }}>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        {{ $reply->likes_count }}
                    </button>
                </form>
            </div>

            @can('delete', $reply)
                <div>
                    <form method="post" action="/replies/{{ $reply->id }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button class="btn btn-outline-danger btn-sm" type="submit">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>