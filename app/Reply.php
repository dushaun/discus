<?php

namespace App;

use App\Traits\Favouritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favouritable;

    protected $guarded = [];
    protected $with = ['owner', 'favourites'];

    /**
     * A reply belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
