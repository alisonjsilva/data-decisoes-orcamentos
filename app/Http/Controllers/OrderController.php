<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialsOrders;
use App\Order;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;
use App\Exports\OrderExport;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;
use App\MaterialType;


class OrderController extends Controller
{
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->middleware('auth');
        $this->excel = $excel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')->orderBy('id', 'desc')->get();

        return view('admin.listOrders', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status_list =  DB::table('orders_status')->get();
        $status_list_materials =  DB::table('materials_status')->get();
        return view(
            'admin.formOrder',
            [
                'status_list' => $status_list,
                'status_list_materials' => $status_list_materials
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($request->title))
            return;

        $order = new Order();
        $order->title = $request->title;
        $order->description = $request->description;
        $order->status = $request->status;

        $order_array = $order->toArray($order);

        $now = \Carbon\Carbon::now();
        $order_array['created_at'] = $now;
        $order_array['updated_at'] = $now;

        $order_id = $order->insertGetId($order_array);

        if ($order_id > 0) {
            $materials = $request->input('materials');

            if (isset($materials)) {
                $table = DB::table('materials_orders');

                $i = 0;
                foreach ($materials as $material) {
                    if ($material['title'] && !empty($material['title'])) {
                        $material['order_id'] = $order_id;
                        $material['created_at'] = $now;
                        $material['updated_at'] = $now;

                        if (isset($material['delivery_date'])) {
                            $date =  new DateTime($material['delivery_date']);
                            $material['delivery_date'] = $date;
                        }

                        $material['ord'] = $i;
                        $table->insert(
                            $material
                        );
                        $i++;
                    }
                }
            }
        }
        return redirect()->route('order.edit', $order_id);
    }

    public function createOrderFromProposal(int $id)
    {
        if (is_null($id))
            return;

        $materials = DB::table('proposal_services')

            ->where('proposal_services.proposal_id', '=', $id)
            ->whereNotNull('proposal_services.service_id')
            ->join('services_materials', 'proposal_services.service_id', '=', 'services_materials.service_id')
            ->join('materials', 'services_materials.material_id', '=', 'materials.id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'materials.supplier_id')
            ->leftJoin('categories', 'proposal_services.category_id' , '=', 'categories.id')
            ->select(
                'materials.title',
                'materials.description',
                'materials.unit',
                'materials.quantity',
                'materials.price',
                "materials.unit_price",
                "materials.type_id",
                'proposal_services.id AS service_id',
                'proposal_services.quantity AS proposal_quantity',
                'proposal_services.tab_name',
                'proposal_services.category_id',
                'suppliers.title AS supplier_title',
                'suppliers.id AS supplier_id',
                'categories.title AS category_title'
            )
            ->get();

        $proposal = DB::table('proposals')
            ->select('name')
            ->where('id', '=', $id)
            ->first();
            //dd($materials);
        //order
        $order = new Order();
        $order->title = 'Encomenda: ' . $proposal->name . ' #' . $id;
        $order->proposal_id = $id;

        $order_array = $order->toArray($order);

        $now = \Carbon\Carbon::now();
        $order_array['created_at'] = $now;
        $order_array['updated_at'] = $now;

        $order_id = $order->insertGetId($order_array);

        if ($order_id > 0) {
            if (isset($materials)) {
                $materials_array = $materials->toArray($materials);
                //$materialOrders = new MaterialsOrders();

                $table = DB::table('materials_orders');

                $i = 0;
                foreach ($materials as $material) {

                    $material->quantity = $material->proposal_quantity;
                    $material->subtotal = $material->proposal_quantity * $material->unit_price;
                    $material->price = $material->unit_price; // we dont have unit_price on material table
                    unset($material->proposal_quantity);
                    unset($material->unit_price);

                    $material->id = null;
                    $material->order_id = $order_id;
                    $material->created_at = $now;
                    $material->updated_at = $now;

                    $material->ord = $i;
                    $table->insert((array) $material);
                    $i++;
                }
            }
        }

        return response()->json(['success' => true, 'order_id' => $order_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = Order::find($order->id);
        $services = $order->materials->groupBy('tab_name');
        //dd($services);
        return view(
            'admin.showOrder',
            [
                'order' => $order,
                'services' => $services
            ]
        );
        //print_r($services->groupBy('tab_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order = $order->load('materials');

        $status_list =  DB::table('orders_status')->get();
        $status_list_materials =  DB::table('materials_status')->get();
        $types = MaterialType::all();

        return view(
            'admin.formOrder',
            [
                'order' => $order,
                'status_list' => $status_list,
                'status_list_materials' => $status_list_materials,
                'types' => $types
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if (is_null($request->title))
            return;

        $order->title = $request->title;
        $order->description = $request->description;
        $order->status = $request->status;

        $now = \Carbon\Carbon::now();

        $success = $order->save();
        if ($success == true) {
            $materials = $request->input('materials');
            if (isset($materials)) {
                //dd($materials);
                $i = 0;
                foreach ($materials as $material) {
                    if ($material['title'] && !empty($material['title'])) {
                        $material['order_id'] = $order->id;
                        $material['updated_at'] = $now;

                        if (isset($material['delivery_date'])) {
                            $date =  new DateTime($material['delivery_date']);
                            $material['delivery_date'] = $date;
                        }

                        $material['ord'] = $i;

                        $table = DB::table('materials_orders');
                        $table->updateOrInsert(
                            ['id' => isset($material['id']) ? $material['id'] : 0, 'order_id' => $order->id],
                            $material
                        );
                        $i++;
                    }
                }
            }
        }

        return redirect()->route('order.edit', $order->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Order::where('id', $order->id)->delete();

        return redirect()->route('order.index');
    }

    public function destroyAjax(Order $order)
    {
        //
    }

    public function exportOrder() {
        return Excel::download(new OrderExport, 'order.xlsx');
    }

    public function exportOrderById(int $id) {
        $date = new DateTime();
        $order = new OrderExport();
        $order->id = $id;
        return Excel::download($order, 'encomenda-'.$id. '-' . $date->format('m-d-Y').'.xlsx');
        //return (new OrderExport)->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
