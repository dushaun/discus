<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LikesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_can_not_like_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/likes')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_like_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/likes');

        $this->assertCount(1, $reply->likes);
    }

    /** @test */
    public function an_authenticated_user_may_only_like_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/likes');
            $this->post('replies/' . $reply->id . '/likes');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->likes);
    }
}