<?php

namespace App\Http\Controllers;

use App\Material;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers;
use App\Helpers\MaterialHelpers;
use App\ServiceMaterials;
use App\Unit;
use App\MaterialType;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = DB::table('materials')
            ->leftJoin('suppliers', 'materials.supplier_id', '=', 'suppliers.id')
            ->select('materials.*', 'suppliers.title AS supplier_title')
            ->orderBy('id', 'desc')
            ->get();


        return view('admin.listMaterials', [
            'materials' => $materials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        $types = MaterialType::all();

        return view('admin.formMaterial',
        [
            'units' => $units,
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $material = new Material();
        $material->title = $request->title;
        $material->description = $request->description;
        $material->unit = $request->unit;
        $material->quantity = $request->quantity;
        $material->price = $request->price;
        $material->unit_value = $request->unit_value;
        $material->unit_price = $request->unit_price;
        $material->type_id = $request->type_id;

        $material->supplier_id = MaterialHelpers::getOrAddSupplier($request->supplier_title);

        $material->save();

        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $material->load('supplier');
        $units = Unit::all();
        $types = MaterialType::all();
        return view(
            'admin.formMaterial',
            [
                'material' => $material,
                'units' => $units,
                'types' => $types
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $material->title = $request->title;
        $material->description = $request->description;
        $material->unit = $request->unit;
        $material->quantity = $request->quantity;
        $material->price = $request->price;
        $material->unit_value = $request->unit_value;
        $material->unit_price = $request->unit_price;
        $material->type_id = $request->type_id;

        $material->supplier_id = MaterialHelpers::getOrAddSupplier($request->supplier_title);

        $material->save();

        return redirect()->route('material.edit', ['material' => $material->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        Material::where('id', $material->id)->delete();

        return redirect()->route('material.index');
    }

    /**
     * Display a listing of the resource in JSON.
     *
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function listOfMaterials(Request $request)
    {
        $q = $request->input('q');

        $materials = DB::table('materials')
            ->orderBy('id', 'desc')
            ->when($q, function ($query, $q) {
                return $query->where('title', 'like', '%' . $q . '%');
            })
            ->leftJoin('suppliers', 'materials.supplier_id', '=', 'suppliers.id')
            ->select('materials.*', 'suppliers.title AS supplier_title')
            ->get();

        return response()->json($materials);
    }
}
