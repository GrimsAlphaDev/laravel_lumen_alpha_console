<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Console;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();

        $carts = Cart::where('user_id', $user->id)->get();

        $consoles = Console::whereIn('id', $carts->pluck('console_id'))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data cart berhasil ditampilkan',
            'data' => $consoles
        ], 200);
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
        $user = Auth()->user();

        // check user chart, if exist return error

        $cart = Cart::where('user_id', $user->id)->where('console_id', $request->console_id)->first();

        if ($cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Console sudah ada di cart',
            ], 404);
        }

        $cart = new Cart;
        $cart->user_id = $user->id;
        $cart->console_id = $request->console_id;
        $cart->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Data cart berhasil ditambahkan',
            'data' => $cart
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user = Auth()->user();

        $cart = Cart::where('user_id', $user->id)->where('console_id', $request->console_id)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data cart tidak ditemukan',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data cart berhasil dihapus',
        ], 200);
    }
}
