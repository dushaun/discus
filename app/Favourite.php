<?php

namespace App;

use App\Traits\ActivityTracker;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use ActivityTracker;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favouritable()
    {
        return $this->morphTo();
    }
}
