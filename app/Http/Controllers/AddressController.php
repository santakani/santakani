<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only logged in users can upload images
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Address is sensitive data and only be read by the user themselves
        $addresses = Address::with('city')->where('user_id', $request->user()->id)->get();

        return response()->json($addresses);
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
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:city,id',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $address = Address::firstOrNew([
            'user_id' => $request->user()->id,
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'city_id' => $request->input('city_id'),
        ]);

        $address->postcode = $request->input('postcode');
        $address->email = $request->input('email');
        $address->phone = $request->input('phone');

        $address->save();

        $address->load('city.country');

        return response()->json($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $address = Address::find($id);

        if (empty($address)) {
            abort(404);
        }

        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($address);
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
        $address = Address::find($id);

        if (empty($address)) {
            abort(404);
        }

        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postcode' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:city,id',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $address->update([
            'name' => $request->input('name'),
            'street' => $request->input('street'),
            'city_id' => $request->input('city_id'),
            'postcode' => $request->input('postcode'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        $address->load('city.country');

        return response()->json($address);
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
        $address = Address::find($id);

        if (empty($address)) {
            abort(404);
        }

        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        $address->delete();
    }
}
