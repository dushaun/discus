@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <span class="mr-auto">
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                    {{ $thread->title }}
                                </span>

                                @can('delete', $thread)
                                    <form action="{{ $thread->path() }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                    {{--{{ $replies->links() }}--}}

                    @if(auth()->check())
                        <form method="post" action="{{ $thread->path() . '/replies' }}" class="mb-3">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" id="body" placeholder="Reply here..." class="form-control" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">Submit</button>
                            </div>
                        </form>
                    @else
                        <p class="text-center">Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a> to get involved with this conversation.</p>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="mb-0">
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a> and currently
                                has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection