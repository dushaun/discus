<?php

namespace Tests\Feature;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_checks_got_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_repeated_keys()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('Hello world aaaaaaaaaaa');
    }
}