<?php

namespace App\Http\Controllers;

use App\Service;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ServiceMaterials;

class ServiceController extends Controller
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
        // $services = Service::all();
        // dd($services);
        $services = DB::table('services')
            ->join('categories', function ($join) {
                $join->on('services.category_id', '=', 'categories.id');
            })
            ->select('services.*', 'categories.title AS cat_name')
            ->get();


        return view('admin.listServices', [
            'services' => $services
        ]);
    }

    /**
     * Display a listing of the resource in JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOfServices(Request $request)
    {
        $q = $request->input('q');
        //$services = Service::all();
        $services = DB::table('services')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            //->where('title', 'like', '%' . $q . '%')
            ->select('services.*', 'categories.title AS cat_name')

            ->get();

        //dd($services);
        return response()->json($services);
    }

    public function servicesByCategory(Request $request, $catid)
    {
        if (isset($catid)) {

            $services = DB::table('services')
                ->join('categories', function ($join) use ($catid) {
                    $join->on('services.category_id', '=', 'categories.id')
                        ->where('services.category_id', '=', $catid);
                })
                ->select('services.*', 'categories.title AS cat_name')
                ->get();

            return response()->json($services);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        //dd($categoies);
        return view('admin.formServices', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->unit = $request->unit;
        $service->quantity = $request->quantity;
        $service->price = $request->price;
        $service->category_id = $request->category;
        $service->quantity_calc = $request->quantity_calc;

        $service->save();

        return redirect()->route('service.index');
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return 1;
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('admin.formServices', ['categories' => $categories, 'service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //dd($request);
        //$service = Service::find($request->id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->unit = $request->unit;
        $service->quantity = $request->quantity;
        $service->price = $request->price;
        $service->category_id = $request->category;
        $service->quantity_calc = $request->quantity_calc;

        $service->save();

        DB::table('services_materials')->where('service_id', '=', $service->id)->delete();
        if (isset($request->selections) && $request->selections !== null) {
            $service_materials = new ServiceMaterials();

            $selections = explode(",", $request->selections);
            $array_to_insert = array();

            $pos = 0;
            foreach ($selections as $selection) {
                array_push(
                    $array_to_insert,
                    [
                        'service_id' => $service->id,
                        'material_id' => $selection,
                        'ord' => $pos
                    ]
                );
                $pos++;
            }

            $service_materials->insert($array_to_insert);
        }

        return redirect()->route('service.index', ['service' => $service->id]);

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        Service::where('id', $service->id)->delete();

        return redirect()->route('service.index');
    }

    public function servicesByPackageId($id)
    {
        $services = DB::table('services')
            ->join('packages_services', function ($join) use ($id) {
                $join->on('services.id', '=', 'packages_services.service_id')
                    ->where('packages_services.package_id', '=', $id);
            })
            //->join('packages_services', 'services.id', '=', 'packages_services.service_id')
            ->join('categories', 'services.category_id', '=', 'categories.id')
            ->select('services.*', 'categories.title AS cat_name')
            ->get();

        return response()->json($services);
    }

    /**
     * Return a list of materials associated a service
     *
     * @param  int $id
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function materialsByServiceId($id)
    {
        $services = DB::table('materials')
            ->join('services_materials', function ($join) use ($id) {
                $join->on('materials.id', '=', 'services_materials.material_id')
                    ->where('services_materials.service_id', '=', $id);
            })
            //->join('packages_services', 'services.id', '=', 'packages_services.service_id')
            ->leftJoin('suppliers', 'materials.supplier_id', '=', 'suppliers.id')
            ->select('materials.*', 'suppliers.title AS supplier_title')
            ->get();

        return response()->json($services);
    }
}
