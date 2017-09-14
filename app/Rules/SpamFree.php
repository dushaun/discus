<?php

namespace App\Rules;

use App\Inspections\Spam;
use Exception;

class SpamFree
{
    /**
     * Check if value isn't spam.
     *
     * @param $attribute
     * @param $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (Exception $e) {
            return false;
        }
    }

    // TODO: Add message method when updated to Laravel 5.5
    // TODO: Then remove spamfree validation method from validation.php
}
