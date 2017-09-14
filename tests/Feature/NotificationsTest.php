<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = create('App\Thread')->subscribe();
        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Something interesting looks like its about to happen',
        ]);
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'Something interesting looks like its about to happen',
        ]);
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson('/profiles/'.auth()->user()->name.'/notifications')->json()
        );
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications/".$user->unreadNotifications->first()->id);

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    /** @test */
    public function a_user_can_mark_all_notifications_as_read()
    {
        $thread = create('App\Thread')->subscribe();
        $user = auth()->user();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'Something interesting looks like its about to happen',
        ]);
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'Something interesting looks like it just happened',
        ]);
        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body'    => 'Something interesting looked like it did happen',
        ]);

        $this->assertCount(3, $user->unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
