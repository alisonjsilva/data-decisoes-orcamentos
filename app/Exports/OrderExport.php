<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class OrderExport implements FromView, ShouldAutoSize
{
    public $id;

    public function view(): View
    {
        $order = Order::where('id', $this->id)->with('materials')->first();
        $status = DB::table('materials_status')->get();
        //dd(DB::table('materials_status')->get());
        //dd($order->materials->first()->load('proposalService'));
        //dd($order);
        return view('admin.exportOrder', [
            'status_list' => $status,
            'orders' => $order
        ]);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Order::where('id', $this->id)->with('materials')->get();
    // }

    /**
     * @var Invoice $invoice
     */
    // public function map($order): array
    // {

    //     return [
    //         [
    //             $order->id,
    //             $order->title,
    //         ],

    //         [
    //             $order->title
    //         ]

    //     ];
    //}

    // public function view(): View
    // {
    //     return view('admin.exportOrder', [
    //         'orders' => Order::all()
    //     ]);
    // }
}
