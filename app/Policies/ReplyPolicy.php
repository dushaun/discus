<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        if (!$lastReply = $user->fresh()->lastReply) {
            return true;
        }

        return !$lastReply->wasJustPublished();
    }

    /**
     * Determine whether a user can update their reply.
     *
     * @param User  $user
     * @param Reply $reply
     *
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    /**
     * Determine whether a user can delete their reply.
     *
     * @param User  $user
     * @param Reply $reply
     *
     * @return bool
     */
    public function delete(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
}
