@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->trackable->favouritable->path() }}">{{ $profileUser->name }} favourited a reply</a>
    @endslot

    @slot('date')
        {{ $activity->trackable->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->trackable->favouritable->body }}
    @endslot
@endcomponent