<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="#">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>
                <form method="post" action="/replies/{{ $reply->id }}/favourites">
                    {{ csrf_field() }}

                    <button type="submit" {{ $reply->isFavourited() ? 'disabled' : '' }}>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        {{ $reply->favourites_count }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>