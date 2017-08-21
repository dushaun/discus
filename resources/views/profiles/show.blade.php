@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="page-header mb-5">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                @forelse($activities as $date => $activity)
                    <h3 class="page-header mt-4 mb-4">{{ $date }}</h3>

                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <div class="card">
                        <div class="card-body">
                            There is no activity from this user at this time.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection