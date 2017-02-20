<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'query' => 'required|string|max:50',
            'type' => 'string|in:design,designer,place,story,user',
        ]);

        if ($request->has('type')) {
            $type = $request->input('type');
        } else {
            $type = 'design';
        }

        switch ($type) {
            case 'design':
                $results = \App\Design::search($request->input('query'))->paginate(24);
                break;
            case 'designer':
                $results = \App\Designer::search($request->input('query'))->paginate(24);
                break;
            case 'place':
                $results = \App\Place::search($request->input('query'))->paginate(24);
                break;
            case 'story':
                $results = \App\Story::search($request->input('query'))->paginate(24);
                break;
            case 'user':
                $results = \App\User::search($request->input('query'))->paginate(24);
                break;
            default:
                $results = \App\Design::search($request->input('query'))->paginate(24);
                break;
        }

        $result_counts = [
            'design' => count(\App\Design::search($request->input('query'))->take(99)->get()),
            'designer' => count(\App\Designer::search($request->input('query'))->take(99)->get()),
            'place' => count(\App\Place::search($request->input('query'))->take(99)->get()),
            'story' => count(\App\Story::search($request->input('query'))->take(99)->get()),
            'user' => count(\App\User::search($request->input('query'))->take(99)->get()),
        ];

        return view('pages.search', [
            'type' => $type,
            'query' => $request->input('query'),
            'results' => $results,
            'result_counts' => $result_counts,
        ]);
    }
}
