@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->trackable->likable->path() }}">{{ $profileUser->name }} liked a reply</a>
    @endslot

    @slot('date')
        {{ $activity->trackable->likable->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->trackable->likable->body }}
    @endslot
@endcomponent