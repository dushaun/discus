<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given I have a user who is signed in.
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        // And another user
        $jane = create('App\User', ['name' => 'JaneDoe']);

        // If we have a thread
        $thread = create('App\Thread');
        // And signed in user replies and mentions @NewUser
        $reply = make('App\Reply', [
            'body' => '@JaneDoe look at this.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Then the new user should be notified
        $this->assertCount(1, $jane->notifications);
    }
}
