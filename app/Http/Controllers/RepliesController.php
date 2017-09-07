<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\Spam;
use Exception;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Return list of paginated replies
     *
     * @param $channel
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Store reply to thread
     *
     * @param $channel
     * @param Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     */
    public function store($channel, Thread $thread, Spam $spam)
    {
        try {
            $this->validateReply($spam);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (Exception $e) {
            return response('Sorry, your reply could not be saved at this time', 422);
        }

        return $reply->load('owner');
    }

    /**
     * Update a reply
     *
     * @param Reply $reply
     * @param Spam $spam
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        try {
            $this->validateReply($spam);
            $reply->update(['body' => request('body')]);
        } catch (Exception $e) {
            return response('Sorry, your reply could not be saved at this time', 422);
        }
    }

    /**
     * Delete selected reply
     * TODO: Add SoftDeletes to replies
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back()->with('flash', 'Your reply was deleted');
    }

    /**
     * @param Spam $spam
     */
    protected function validateReply(Spam $spam)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);
        $spam->detect(request('body'));
    }
}
