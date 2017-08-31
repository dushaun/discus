<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return all of user's unread notifications
     *
     * @param User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark a selected notification as read
     *
     * @param User $user
     * @param $notificationId
     */
    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}