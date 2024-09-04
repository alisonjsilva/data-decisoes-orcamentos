<?php

namespace App\Http\Controllers;

use App\MaterialsOrders;
use Illuminate\Http\Request;

class MaterialsOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\MaterialsOrders  $materialsOrders
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialsOrders $materialsOrders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialsOrders  $materialsOrders
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialsOrders $materialsOrders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialsOrders  $materialsOrders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialsOrders $materialsOrders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialsOrders  $materialsOrders
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialsOrders $materialsOrders)
    {
        //
    }

    public function destroyAjax(int $id)
    {
        MaterialsOrders::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }
}
