<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    /**
     * ThreadSubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Subscribe user to selected thread.
     *
     * @param $channelId
     * @param Thread $thread
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Unsubscribe user from selected thread.
     *
     * @param $channelId
     * @param Thread $thread
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
