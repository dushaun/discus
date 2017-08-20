<?php

namespace App;

use App\Traits\ActivityTracker;
use App\Traits\Likable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Likable, ActivityTracker;

    protected $guarded = [];
    protected $with = ['owner', 'likes'];

    /**
     * A reply belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A reply belongs to a thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
