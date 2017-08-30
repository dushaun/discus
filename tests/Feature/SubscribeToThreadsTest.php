<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $otherUser = create('App\User');

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        // Then, each time a new reply is left...
        $thread->addReply([
            'user_id' => $otherUser->id,
            'body' => 'Something interesting looks like its about to happen'
        ]);

        // A notification should be prepared for the user
//        $this->assertCount(1, auth()->user()->notifications);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);
    }
}