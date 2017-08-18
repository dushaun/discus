<?php

namespace App\Traits;

use App\Activity;

trait ActivityTracker
{
    /**
     * Boot method to track activity
     */
    protected static function bootActivityTracker()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToTrack() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * Array of trackable activities
     *
     * @return array
     */
    protected static function getActivitiesToTrack()
    {
        return ['created'];
    }

    /**
     * A given model can have many activities
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'trackable');
    }

    /**
     * Save a tracked activity
     *
     * @param $event
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * Generate name of activity type
     *
     * @param $event
     * @return string
     */
    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}