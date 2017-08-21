<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{$reply->id}}" class="card mb-3">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}
                </div>

                @if(Auth::check())
                    <div>
                        <like :reply="{{ $reply }}"></like>
                    </div>
                @endif

                <div class="ml-1">
                    <button :class="classes" @click="optionsToggle">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                </div>
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

        <div class="card-footer" v-if="options">
            @can('update', $reply)
            <button class="btn btn-success btn-sm mr-2" @click="editing = true">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </button>
            <button class="btn btn-outline-danger btn-sm" @click="destroy">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
            @endcan
        </div>

    </div>
</reply>