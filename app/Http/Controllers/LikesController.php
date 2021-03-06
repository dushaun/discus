<?php

namespace App\Http\Controllers;

use App\Like;
use App\Reply;

class LikesController extends Controller
{
    /**
     * LikesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new like.
     *
     * @param Reply $reply
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Reply $reply)
    {
        $reply->like();

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unlike();
    }
}
