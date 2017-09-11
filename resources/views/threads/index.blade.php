@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="card mb-3">
                @forelse($threads as $thread)
                    <div class="card-body">
                        <div>
                            <div class="d-flex justify-content-between">
                                <div class="mr-auto">
                                    <a href="{{ $thread->path() }}"
                                       class="h5 text-primary">
                                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                            <strong>
                                                {{ $thread->title }}
                                            </strong>
                                        @else
                                            {{ $thread->title }}
                                        @endif
                                    </a>
                                </div>

                                <a href="{{ $thread->path() }}"
                                   class="text-right"
                                   style="min-width: 80px">
                                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                </a>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <p class="text-muted mb-0">
                                    <small><em>by <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a></em></small>
                                </p>
                            </div>
                        </div>
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                @empty
                    <div class="card-body">
                        <p class="mb-0">There are not relevant results at this time.</p>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection