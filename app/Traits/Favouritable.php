<?php

namespace App\Traits;

use App\Favourite;
use Illuminate\Database\Eloquent\Model;

trait Favouritable
{
    /**
     * A reply can have many favourites
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    /**
     * Allow user to favourite a reply
     *
     * @return Model
     */
    public function favourite()
    {
        $attribute = ['user_id' => auth()->id()];

        if (!$this->favourites()->where($attribute)->exists()) {
            return $this->favourites()->create($attribute);
        }
    }

    /**
     * Check if a user has favourited a reply
     *
     * @return bool
     */
    public function isFavourited()
    {
        return !!$this->favourites->where('user_id', auth()->id())->count();
    }

    /**
     * Create a favourites_count variable
     *
     * @return mixed
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}