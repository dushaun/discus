<div id="reply-{{$reply->id}}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>
                <form method="post" action="/replies/{{ $reply->id }}/likes">
                    {{ csrf_field() }}

                    <button type="submit" {{ $reply->isLiked() ? 'disabled' : '' }}>
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

                        <button type="submit">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>