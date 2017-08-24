<?php

namespace App;

use App\Traits\ActivityTracker;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use ActivityTracker;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    /**
     * Thread Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $ids = $thread->replies()->pluck('id');
            Reply::destroy($ids);
        });
    }

    /**
     * Return path of the thread
     * 
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * A thread belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread can have many replies
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('likes')
            ->with('owner');
    }

    /**
     * A thread belongs to a channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add a reply to a Thread
     *
     * @param $reply
     * @return Model
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    /**
     * Apply filters to query
     *
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * A user can subscribe to a thread
     * 
     * @param null $userId
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    /**
     * A user can unsubscribe to a thread
     * 
     * @param null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())->delete();
    }

    /**
     * A thread can have many subscriptions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
