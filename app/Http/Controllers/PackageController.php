<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use App\PackageServices;
use App\Service;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
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
        $packages = Package::all();

        return view('admin.listPackages', [
            'packages' => $packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = Package::all();
        //dd($package);
        return view('admin.formPackage', ['package' => $package]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new Package();
        $package->title = $request->title;
        $package->description = $request->description;
        $package->save();
        //dd($package->id);

        if (isset($request->selections) && $request->selections !== null) {
            $packageServices = new PackageServices();

            $selections = explode(",", $request->selections);
            $array_to_insert = array();

            foreach($selections as $selection) {
                array_push($array_to_insert, ['package_id' => $package->id, 'service_id' => $selection]);
            }

            $packageServices->insert($array_to_insert);
            
        }
        
        return redirect()->route('package.edit', ['package' => $package->id]);
        //dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        // $services = DB::table('package_services')
        //                 ->where('package_id', '=', $package->id);
        //dd($package);
        return view('admin.formPackage', ['package' => $package]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {        
        $package->title = $request->title;
        $package->description = $request->description;
        $package->save();
        //dd($package->id);

        DB::table('packages_services')->where('package_id', '=', $package->id)->delete();

        if (isset($request->selections) && $request->selections !== null) {
            $packageServices = new PackageServices();

            $selections = explode(",", $request->selections);
            $array_to_insert = array();

            foreach($selections as $selection) {
                array_push($array_to_insert, ['package_id' => $package->id, 'service_id' => $selection]);
            }

            $packageServices->insert($array_to_insert);
            
        }
        
        return redirect()->route('package.edit', ['package' => $package->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        Package::where('id', $package->id)->delete();

        return redirect()->route('package.index');
    }

    public function packages()
    {
        $services = DB::table('packages')                
                ->select('id', 'title', 'description')
                ->get();

        return response()->json($services);
    }

}
