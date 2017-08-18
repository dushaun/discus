@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ route('profile', $profileUser) }}">{{ $profileUser->name }}</a> replied to:
        <a href="{{ $activity->trackable->thread->path() }}">{{ $activity->trackable->thread->title }}</a>
    @endslot

    @slot('date')
        {{ $activity->trackable->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->trackable->body }}
    @endslot
@endcomponent