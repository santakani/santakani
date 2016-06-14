<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Like;

/**
 * LikeController
 *
 * RESTful APIs for like resource.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Like
 */
class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'likeable_type' => 'required|string',
            'likeable_id' => 'required|integer',
        ]);

        $like = Like::firstOrCreate([
            'likeable_type' => $request->input('likeable_type'),
            'likeable_id' => $request->input('likeable_id'),
            'user_id' => $request->user()->id,
        ]);

        if ($request->has('dislike')) {
            $like->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $like = Like::find($id);

        if (empty($story)) {
            abort(404);
        }

        if ($request->user()->id !== $like->user_id) {
            abort(403);
        }

        $like->delete();
    }
}
