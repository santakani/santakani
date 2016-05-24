<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'search' => 'string',
            'country_id' => 'integer|exists:country,id',
        ]);

        if ($request->has('search') && $request->has('country_id')) {
            $search = $request->input('search');

            $cities = City::whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
                ->where('country_id', $request->input('country_id'))
                ->paginate(15);

        } elseif ($request->has('search')) {
            $search = $request->input('search');

            $cities = City::whereHas('translations', function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
                ->paginate(15);

        } elseif ($request->has('country_id')) {
            $cities = City::where('country_id', $request->input('country_id'))
                ->paginate(15);

        } else {
            $cities = City::paginate(15);

        }

        if ($request->wantsJSON()) {
            return response()->json($cities->toArray(), 200);
        } else {
            return view('page.city.index', ['cities' => $cities]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
