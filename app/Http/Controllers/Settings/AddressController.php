<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

/**
 * Manage user address for shopping and shipment.
 *
 * @author Guo Yunhe guoyunhebrave@gmail.com
 */
class AddressController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->with('city')->get();
        return view('pages.settings.address', ['addresses' => $addresses]);
    }

}
