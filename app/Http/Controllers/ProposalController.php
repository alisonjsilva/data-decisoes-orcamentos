<?php

namespace App\Http\Controllers;

use App\Proposal;
use App\Iva;
use App\Service;
use App\ProposalServices;
use App\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
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
    //$proposals = Proposal::all();
    $proposals = DB::table('proposals')->orderBy('id', 'desc')->get();
    // $proposals = DB::table('proposals')
    //         ->join('categories', function ($join) {
    //             $join->on('services.category_id', '=', 'categories.id');
    //         })
    //         ->select('services.*', 'categories.title AS cat_name')
    //         ->get();

    return view('admin.listProposals', [
      'proposals' => $proposals
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $ivas = DB::table('iva')->get();
    return view('admin.createProposal', [
        'proposal' => null,
        'ivas' => $ivas
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
    dd($request);
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Proposal  $proposal
   * @return \Illuminate\Http\Response
   */
  public function show(Proposal $proposal)
  {
    $services = Proposal::find($proposal->id)
      ->services
      ->sortBy('category_id');


    $services = $services->load('category');
    $categories_sum = $services->groupBy('category_id')
      ->map(function ($row) {
        return $row->sum('subtotal');
      });
    //dd($categories_sum);

    $total = $services->sum('subtotal');
    //dd($total);
    $divisions = $services->unique('tab_name')->pluck('tab_name');

    //dd($divisions);

    $categories = $services->groupBy('category_id');
    //dd($categories);
    $services2 = Proposal::find($proposal->id)
      ->services
      ->sortBy('tab_name')
      ->sortBy('category_id');
    //dd($services2['Cozinha']);

    $iva = DB::table('iva')
      ->select('*')
      ->where('id', '=', $proposal->iva_id)
      ->first();

    return view('admin.showProposal', [
      'proposal' => $proposal, 'services' => $services,
      'divisions' => $divisions, 'categories_sum' => $categories_sum,
      'total' => $total, 'categories' => $categories, 'services2' => $services2,
      'iva' => $iva
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Proposal  $proposal
   * @return \Illuminate\Http\Response
   */
  public function edit(Proposal $proposal)
  {
    $services = Proposal::find($proposal->id)
      ->services
      ->sortBy('id')
      ->sortBy('ord');

    $services = $services->load('category');

    $divisions = $services->unique('tab_name');

    $order = DB::table('orders')
      ->select('id')
      ->where('proposal_id', '=', $proposal->id)
      ->first();

    $tabs = $proposal->tabs;
    $iva = DB::table('iva')->get();
    //dd($tabs);

    return view('admin.createProposal', [
      'proposal' => $proposal,
      'services' => $services,
      'divisions' => $divisions,
      'order' => $order,
      'tabs' => $tabs,
      'ivas' => $iva
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Proposal  $proposal
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Proposal $proposal)
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function postProposalAjax(Request $request)
  {

    $client = $request->input('client');
    $tabs = $request->input('tabs');

    if (isset($client) && $client !== null && !empty($client['name'])) {
      $proposal = new Proposal();
      $client['created_at'] = \Carbon\Carbon::now();
      $proposal_id = $proposal->insertGetId($client);

      return $proposal_id;
    }
  }

  public function updateProposalAjax(Request $request)
  {
    //dd($request);
    $client = $request->input('client');
    $tab = $request->input('tab');
    $deletes = $request->input('deletes');
    $proposal_id = $request->input('id');

    $proposal = new Proposal();

    if (isset($proposal_id) && isset($client) && $client !== null && !empty($client['name'])) {

      $proposal = $proposal->where('id', $request->input('id'))->update($client);
      //dd($proposal);
      $service = new ProposalServices();
      //dd($tabs);
      if (isset($tab) && $tab !== null) {
        if (array_key_exists('jobs', $tab)) {

          $jobs = $tab['jobs'];
          // remove jobs to save tabs
          $new_tab = $tab;
          unset($new_tab['jobs']);
          $new_tab['proposal_id'] = $proposal_id;
          $new_tab_array_id = array('proposal_id' => $new_tab['proposal_id'], 'tab_id' => $new_tab['tab_id']);
          //dd($new_tab_array_id);
          $tab_model = new Tab();
          $tab_model->updateOrInsert($new_tab_array_id, $new_tab);
          //dd($new_tab_array_id);

          foreach ($jobs as $key => $job) {
            $job['proposal_id'] = $proposal_id;
            $arrayId = array('id' => isset($job['id']) ? $job['id'] : 0);
            //dd($arrayId);

            $service->updateOrInsert($arrayId, $job);
          }

          //return app('db')->getPdo()->lastInsertId();
        }
      }

      //deletes
      if (isset($deletes) && $deletes !== null) {
        $service->whereIn('id', $deletes)->delete();
      }

      return $proposal_id;
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Proposal  $proposal
   * @return \Illuminate\Http\Response
   */
  public function destroy(Proposal $proposal)
  {
    // $services = Proposal::find($proposal->id)
    //   ->services;
    ProposalServices::where('proposal_id', $proposal->id)->delete();
    Proposal::where('id', $proposal->id)->delete();

    return redirect()->route('proposal.index');
  }
}
