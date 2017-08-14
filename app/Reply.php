<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

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
     * A reply can have many favourites
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    public function favourite()
    {
        $attribute = ['user_id' => auth()->id()];

        if (! $this->favourites()->where($attribute)->exists()) {
            return $this->favourites()->create($attribute);
        }
    }
}
