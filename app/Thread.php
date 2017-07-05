<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * Return path of the thread
     * 
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id;
    }

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
        return $this->hasMany(Reply::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
