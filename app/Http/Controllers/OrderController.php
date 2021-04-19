<?php

namespace App\Http\Controllers;

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
        return Order::all();
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

        $request->validate(['numOrder' => 'required',
            'product_ids' => 'required', 'quantite' => 'required',
            
        ]);

        $order = Order::create($request->all());
        $product = explode(',', $request->product_ids);
        $quantite = explode(',', $request->quantite);
        for ($i = 0; $i < count($product); $i++) {
            $order->Products()->attach([$product[$i] => ['quantite' => $quantite[$i]]]);
        }

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
    public function show(Order $order)
    {
        return Order::find($order);
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
    public function update(Request $request, Order $order)
    {
        $order = Order::findOrFail($order);
        $input = $request->all();
        $order->libelle = $input['numOrder'];

        $product = explode(',', $request->product_ids);
        $quantite = explode(',', $request->quantite);
        for ($i = 0; $i < count($product); $i++) {
            $order->products()->sync([$product[$i] => ['quantite' => $quantite[$i]]]);
        }
        if ($order->save()) {
            return response()->json([
                'message' => 'Modification de la commande ' . $order->get('numOrder') . ' effectuée',
            ], 201);
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
