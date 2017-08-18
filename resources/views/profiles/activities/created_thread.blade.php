@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ route('profile', $profileUser) }}">{{ $profileUser->name }}</a> posted:
        <a href="{{ $activity->trackable->path() }}">{{ $activity->trackable->title }}</a>
    @endslot

    @slot('date')
        {{ $activity->trackable->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->trackable->body }}
    @endslot
@endcomponent