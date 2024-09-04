<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Título</th>
            <th>Fornecedor</th>
            <th>Status</th>
            <th>Produto</th>
            <th>Divisão</th>
            <th>Serviço</th>
            <th>Categoria</th>
            <th>Un.</th>
            <th>Qt.</th>
            <th>Preço</th>
            <th>Subtotal</th>
            <th>Data Entrega</th>
            <th>Qt. Final</th>
            <th>Preço final</th>
            <th>Subtotal Final</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($orders->materials->load('proposalService') as $order)
            <?php
            $service = DB::table('proposal_services')
                ->where('id', '=', $order->service_id)
                ->first();
            $status_order = null;
            foreach ($status_list as $status) {
                if ($status->id === $order->status) {
                    $status_order = $status->title;
                }
            }
            ?>
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->title }}</td>
                <td>{{ $order->supplier_title }}</td>
                <td>{{ $status_order }}</td>
                <td>{{ $order->description }}</td>
                <td>{{ $order->tab_name }}</td>
                <td>{{ isset($service->title) ? $service->title : '' }}</td>
                <td>{{ $order->category_title }}</td>
                <td>{{ $order->unit }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->subtotal }}</td>
                <td>{{ $order->delivery_date }}</td>
                <td>{{ $order->final_quantity }}</td>
                <td>{{ $order->final_price }}</td>
                <td>{{ $order->final_subtotal }}</td>
            </tr>

        @endforeach


    </tbody>

</table>
