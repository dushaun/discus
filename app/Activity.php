<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /**
     * An activity morphs to a specific subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function trackable()
    {
        return $this->morphTo();
    }
}
