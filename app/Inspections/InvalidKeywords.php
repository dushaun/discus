<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * Compare body against known spam keywords
     *
     * @param $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}