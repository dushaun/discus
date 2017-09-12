@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card highlight mb-4">
                        <div class="card-body">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <div class="mr-auto h5">
                                        {{ $thread->title }}
                                    </div>

                                    @can('delete', $thread)
                                        <form action="{{ $thread->path() }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button class="btn btn-outline-danger btn-sm border-0" type="submit">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <p class="text-muted mb-0">
                                        <small><em>by <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a></em></small>
                                    </p>
                                </div>
                            </div>
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>

                <div class="col-md-4">
                    <div class="card highlight mb-3">
                        <div class="card-body">
                            <p class="mb-2">
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> and currently
                                has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                            </p>

                            <p class="mb-0">
                                <subscribe-button :active="{{ json_encode($thread->isSubscribed) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection