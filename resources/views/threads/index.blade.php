@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                @forelse($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="level">
                                <div class="flex">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                </div>

                                <a href="{{ $thread->path() }}">
                                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                                <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body">
                            <p>There are not relevant results at this time.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection