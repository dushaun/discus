<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="card mb-3">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}
                </div>

                <div>
                    <form method="post" action="/replies/{{ $reply->id }}/likes">
                        {{ csrf_field() }}

                        <button class="btn btn-outline-primary btn-sm border-0" type="submit" {{ $reply->isLiked() ? 'disabled' : '' }}>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            {{ $reply->likes_count }}
                        </button>
                    </form>
                </div>

                @can('update', $reply)
                    <div class="d-inline-flex">
                        <button class="btn btn-outline-success btn-sm mr-2 ml-2" @click="editing = true">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" @click="destroy">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </div>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
    </div>
</reply>