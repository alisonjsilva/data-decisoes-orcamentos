@extends('layouts.app')

@section('title', 'Encomenda')

@section('content')
    <div class="card">
        <div class="card-body">
            {{$order->title}}
            <hr/>
            {{-- <nav class="navbar navbar-light bg-light">
                <a href="/category/create" class="btn btn-primary">+ Adicionar</a>
            </nav> --}}
            <table id="table" data-toggle="table" data-show-footer="true">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Produto</th>
                        <th>Fornecedor</th>
                        <th>Un.</th>
                        <th>Qt.</th>
                        <th>Preço</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $category_service)
                    <?php $i = 0; ?>

                        @foreach ($category_service as $service)
                        @if($i == 0)
                        <tr class="table-active">
                            <td colspan="8"><strong>{{$service->tab_name}}</strong></td>
                        </tr>
                        @endif
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->title}}</td>
                                <td>{{$service->description}}</td>
                                <td>{{$service->supplier_title}}</td>
                                <td>{{$service->unit}}</td>
                                <td>{{$service->final_quantity ? $service->final_quantity : $service->quantity}}</td>
                                <td>{{$service->final_price ? $service->final_price : $service->price}}</td>
                                <td>{{$service->final_subtotal ? $service->final_subtotal : $service->subtotal}}</td>
                            </tr>
                            {{-- {{ dd($category_service) }} --}}
                            <?php $i++; ?>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @push('scripts')
    <style> table {max-width: 1000px;}</style>
    @endpush

@endsection
