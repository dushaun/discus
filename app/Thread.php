<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * Return path of the thread
     * 
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id;
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
}
