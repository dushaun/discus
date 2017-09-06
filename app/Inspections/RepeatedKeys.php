<?php

namespace App\Inspections;

use Exception;

class RepeatedKeys
{
    /**
     * Detect if body has any repeated keys
     *
     * @param $body
     * @throws Exception
     */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception('Your reply contains spam.');
        }
    }
}