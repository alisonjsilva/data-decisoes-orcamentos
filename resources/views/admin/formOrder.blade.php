@extends('layouts.app')

@section('title', 'Encomendas')

@section('content')
    @include('layouts.modalMaterials')
    {{-- {{dd($order->materials[0])}} --}}
    <?php $group_by = !empty(app('request')->input('group_by')) ? app('request')->input('group_by') : 'tab_name'; ?>
    <div class="card">
        <div class="card-body">
            @if (isset($order))
                <a class="btn btn-primary" href="/order/export/{{ $order->id }}" target="_blank">Exportar</a>
                <a class="btn btn-primary" href="/order/{{ $order->id }}" target="_blank">Ver</a>

            @endif
            <hr />
            <form class="repeater" action="{{ isset($order) ? route('order.update', $order) : route('order.store') }}"
                method="POST">
                @if (isset($order))
                    @method('put')
                    <input type="hidden" value="{{ $order->id }}" name="id" />
                @endif
                @csrf

                <input type="hidden" name="selections" />


                <div class="form-group">
                    <label for="title">Nome</label>
                    <input type="text" required value="{{ isset($order->title) ? $order->title : '' }}" name="title"
                        class="form-control" id="title" aria-describedby="titleHelp">
                    <small id="titleHelp" class="form-text text-muted">Nome do serviço</small>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea name="description" class="form-control" id="description"
                        aria-describedby="descriptionHelp">{{ isset($order->description) ? $order->description : '' }}</textarea>
                    <small id="descriptionHelp" class="form-text text-muted">Descrição do serviço</small>
                </div>

                <div class="form-group">
                    <label for="category">Status</label>
                    <select type="text" name="status" class="form-control" id="status" aria-describedby="titleHelp">
                        <option>
                            @foreach ($status_list as $status)
                        <option {{ isset($order) && $order->status == $status->id ? 'selected' : '' }}
                            value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                    <small id="categoryHelp" class="form-text text-muted">Status desta emcomenda</small>

                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Materiais</h5>
                    </div>

                    <div class="card-body p-0">

                        <div class="m-3 main-repeater" data-repeater-list="materials">
                            @include('layouts.MaterialsInOrderFields')

                            @if (isset($order->materials))
                                <?php $order_materials = $order->materials
                                ->load('proposalService')
                                ->sortBy('ord')
                                ->groupBy($group_by);
                                //->groupBy('tab_name');
                                //dd($order_materials);
                                ?>
                                <div class="accordion" id="accordionOrder">
                                    <?php
                                    $i = 0;
                                    $count_mt = 0;
                                    ?>
                                    @foreach ($order_materials as $key1 => $materials)

                                        <div class="card">
                                            <div class="card-header" id="heading{{ $i }}">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapse{{ $i }}"
                                                        aria-expanded="true" aria-controls="collapse{{ $i }}">
                                                        @if ($group_by == 'category_title')
                                                            {{ $materials->first()->category_title == '' ? 'Sem categoria' : $materials->first()->category_title }}
                                                        @elseif ($group_by == 'type_id')
                                                        <?php if(empty($materials->first()->type_id)) {
                                                            echo 'Sem tipo';
                                                        } else {
                                                            foreach($types as $type) {
                                                                if($type->id == $materials->first()->type_id) {
                                                                    echo $type->title;
                                                                }
                                                            }
                                                        } ?>

                                                        @else
                                                            {{ $materials->first()->tab_name == '' ? 'Sem divisão' : $materials->first()->tab_name }}
                                                        @endif
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $i }}" class="collapse"
                                                    aria-labelledby="heading{{ $i }}"
                                                    data-parent="#accordionOrder">
                                                    <div class="card-body card-division-list">
                                                        @foreach ($materials as $key => $material)

                                                            @include('layouts.MaterialsInOrderFields')

                                                            <?php $count_mt++; ?>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                            @endif
                        </div>



                    </div>

                </div>



                <nav class="navbar fixed-bottom navbar-light bg-primary">
                    <div class="footerbtns-left">
                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                        data-target="#modalTableMaterials">Adicionar materiais</button>
                    <input data-repeater-create type="button" class="btn btn-secondary" value="Adicionar Linha" />
                    <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    <div class="footerbtns-right"> Ordernar por:
                        <a class="btn btn-secondary" href="?group_by=tab_name">
                            Divisão</a>

                        <a class="btn btn-secondary" href="?group_by=category_title">
                            Categoria</a>

                        <a class="btn btn-secondary " href="?group_by=type_id">
                            Tipo Material</a>
                    </div>
                </nav>

            </form>
        </div>
    </div>

    @push('scripts')
        <script src="/public/admin/js/libs/jquery.repeater.js"></script>
        <script>
            window._row = []; // this store the rows value to add in inputs
            $(document).ready(function() {
                $('.repeater').repeater({
                    initEmpty: true,
                    defaultValues: {
                        //'title': def_title
                    },
                    // This is called before append new input row
                    show: function(e) {
                        // we can't access the row here, then we need to user a global var _row

                        handleInputsBeforeAdd(this);
                        $(this).slideDown();
                        window._row = [];
                    },
                    hide: function(deleteElement) {
                        if (confirm('Tem certeza que deseja eliminar?')) {
                            $(this).slideUp(deleteElement);
                            let id = $(this).find('input[data-name=id]').val();
                            if (id !== '') {
                                console.log($(this).find('input[data-name=id]').val());

                                $.ajax({
                                        method: "GET",
                                        url: "/api/materialsorders/destroy/" + id,
                                        dataType: 'JSON',
                                    })
                                    .done(function(result) {
                                        $.notify('<strong>Eliminado com sucesso</strong>', {
                                            type: 'success',
                                            allow_dismiss: true,
                                        });
                                    })
                                    .fail(function(error) {
                                        $.notify('<strong>Erro ao eliminar </strong>', {
                                            type: 'danger',
                                            allow_dismiss: true,
                                            timer: 5000
                                        });
                                    });
                            }
                        }
                    },
                    ready: function(setIndexes) {
                        $(".main-repeater").on('drop', setIndexes);
                    },
                    isFirstItemUndeletable: true
                });

                $('.to_show').attr('data-repeater-item', '');
            });

            var _toeuro = function(value) {
                return value.toLocaleString("pt-PT", {
                    style: "currency",
                    currency: "EUR",
                    minimumFractionDigits: "2",
                    currencyDisplay: "symbol"
                });
            }

            $(document).on('change', 'input[data-name=quantity], input[data-name=price]', function(e) {
                let name = $(e.currentTarget).attr('data-name');
                let $parent = $(this).parent('div').parent('div');

                let price = $parent.find('.price').val();
                let quantity = $parent.find('.quantity').val();

                if (price !== undefined && quantity !== undefined) {
                    let subtotal = _toeuro(price * quantity);
                    $parent.find('input[data-name=subtotal]').val(subtotal.replace('€', '').replace(',', '.'));
                }

            });

            $(document).on('change', 'input[data-name=final_quantity], input[data-name=final_price]', function(e) {
                let name = $(e.currentTarget).attr('data-name');
                let $parent = $(this).parent('div').parent('div');

                let price = $parent.find('.final_price').val();
                let quantity = $parent.find('.final_quantity').val();

                if (price !== undefined && quantity !== undefined) {
                    let subtotal = _toeuro(price * quantity);
                    $parent.find('input[data-name=final_subtotal]').val(subtotal.replace('€', '').replace(',', '.'));
                }
            });

            var addNewMaterialRow = function(row) {
                //console.log(row);
                window._row = row;
                $('input[data-repeater-create]').click();
            }

            var handleInputsBeforeAdd = function(e) {
                if (window._row.length === 0)
                    return;

                let values = window._row;
                let inputs = $(e).find('input');
                let title = $(e).find('input[data-name=title]');
                let price = $(e).find('input[data-name=price]');
                let unit = $(e).find('input[data-name=unit]');
                let quantity = $(e).find('input[data-name=quantity]');
                let supplier_title = $(e).find('input[data-name=supplier_title]');
                let supplier_id = $(e).find('input[data-name=supplier_id]');
                let delivery_date = $(e).find('input[data-name=delivery_date]');
                let description = $(e).find('input[data-name=description]');
                let tab_name = $(e).find('input[data-name=tab_name]');
                let subtotal = $(e).find('input[data-name=subtotal]');
                let category_title = $(e).find('input[data-name=category_title]');
                let type_id = $(e).find('input[data-name=type_id]');

                console.log(values)
                title.val(values.title);
                price.val(values.unit_price);
                unit.val(values.unit);
                quantity.val(values.quantity);
                supplier_title.val(values.supplier_title);
                supplier_id.val(values.supplier_id);
                description.text(values.description);
                tab_name.val(values.tab_name);
                category_title.val(values.category_title);
                type_id.val(values.type_id);

                if (values.unit_price !== undefined && values.quantity !== undefined) {
                    subtotal.val(_toeuro(values.unit_price * values.quantity).replace('€', '').replace(',', '.'));
                }

                //console.log(values['title'])
                console.log(inputs);
            }

            var $materialsTableModal = $('#tableInModalMaterials'); // tabela na modal

            $(function() {
                $('#modalTableMaterials').on('shown.bs.modal', function() {
                    $materialsTableModal.bootstrapTable('resetView')
                })
            });

            $materialsTableModal.bootstrapTable({
                onClickRow: function(row, e) {
                    //$('#tableMaterials').bootstrapTable('append', row);
                    //console.log(row, e);
                    addNewMaterialRow(row);
                }
            });

            $(function() {
                $(".card-division-list").sortable();
                $(".card-division-list").disableSelection();

                $("input[data-name=delivery_date]").datepicker({
                    dateFormat: "dd-mm-yy"
                });
            });



            $("form").submit(function(e) {
                // var selections = $('#tableMaterials').bootstrapTable('getData');
                // selections = selections.map(s => s.id);
                // $('input[name=selections]').val(selections);
            });

        </script>
        <style>
            div.card-division-list>div:nth-of-type(odd) {
                background: #e0e0e0;
            }

            .main-repeater {
                font-size: 12px;
            }

        </style>
    @endpush

@endsection
