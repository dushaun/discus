<?php

namespace App\Http\Controllers;

use App\Favourite;
use App\Reply;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    /**
     * FavouritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favourite
     *
     * @param Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Reply $reply)
    {
        return $reply->favourite();
    }
}
