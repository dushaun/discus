<?php

namespace App\Traits;

use App\Like;
use Illuminate\Database\Eloquent\Model;

trait Likable
{
    /**
     * A reply can have many likes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Allow user to like a reply
     *
     * @return Model
     */
    public function like()
    {
        $attribute = ['user_id' => auth()->id()];

        if (!$this->likes()->where($attribute)->exists()) {
            return $this->likes()->create($attribute);
        }
    }

    /**
     * Check if a user has liked a reply
     *
     * @return bool
     */
    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }

    /**
     * Create a likes_count variable
     *
     * @return mixed
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }
}