<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        RepeatedKeys::class
    ];

    /**
     * Send body for spam detection
     *
     * @param $body
     * @return bool
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}