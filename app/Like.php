<?php

namespace App;

use App\Traits\ActivityTracker;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use ActivityTracker;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likable()
    {
        return $this->morphTo();
    }
}
