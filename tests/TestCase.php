<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign in user
     *
     * @param User $user
     * @return $this
     */
    public function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->be($user);

        return $this;
    }
}
