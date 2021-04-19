<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order as ResourcesOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        $result = [];
        foreach ($orders as $o) {
            array_push($result, new ResourcesOrder($o));
        }
        return $result;
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

        $request->validate([
            'numOrder' => 'required',
            'product_ids' => 'required', 'quantite' => 'required',

        ]);

        $price = 0;
        $order = Order::create($request->all());
        $product = explode(',', $request->product_ids);
        $quantite = explode(',', $request->quantite);
        for ($i = 0; $i < count($product); $i++) {
            $order->Products()->attach([$product[$i] => ['quantite' => $quantite[$i]]]);
            $prodP = $order->recupPriceProduct($product[$i]) * $quantite[$i];
            $price += $prodP;
        }

        $order->price = $price;
        $order->save();
        return response()->json([
            'message' => 'Commande enregistrée'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $order = Order::find($id);
        return new ResourcesOrder($order);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $order = Order::findOrFail($id);
        // return $request->all();
        $input = $request->all();
        $order->numOrder = $input['numOrder'];

        $product = explode(',', $request->product_ids);
        $quantite = explode(',', $request->quantite);

        $order->Products()->detach();
        for ($i = 0; $i < count($product); $i++) {
            $order->Products()->attach([$product[$i] => ['quantite' => $quantite[$i]]]);
        }

        if ($order->save()) {
            return response()->json([
                'message' => 'Modification de la commande  ' . $order->id . ' effectuée',
            ], 201);
        } else {
            return response()->json([
                'message' => 'Modification de la commande  ' . $order->id . ' non effectuée',
            ], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
