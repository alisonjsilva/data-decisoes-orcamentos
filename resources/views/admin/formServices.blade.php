@extends('layouts.app')

@section('title', 'Serviços')

@section('content')
@include('layouts.modalMaterials')
<div class="card">
    <div class="card-body">
        <form class="repeater" action="{{isset($service) ? route('service.update', $service) : route('service.store')}}" method="POST">
            @if(isset($service))
            @method('put')
            <input type="hidden" value="{{$service->id}}" name="id" />
            @endif
            @csrf

            <input type="hidden" name="selections" />

            <div class="form-group">
                <label for="title">Nome</label>
                <input type="text" value="{{isset($service->title) ? $service->title : ''}}" name="title" class="form-control" id="title" aria-describedby="titleHelp">
                <small id="titleHelp" class="form-text text-muted">Nome do serviço</small>
            </div>

            <div class="form-group">
                <label for="category">Categoria</label>
                <select type="text" name="category" class="form-control" id="category" aria-describedby="titleHelp">
                    @foreach($categories as $category)
                    <option {{(isset($service) && $service->category_id == $category->id) ? 'selected' : ''}} value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
                <small id="categoryHelp" class="form-text text-muted">Categoria do serviço</small>

            </div>

            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp">{{isset($service->description) ? $service->description : ''}}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Descrição do serviço</small>
            </div>
            <div class="form-group">
                <label for="unit">Unidade</label>

                <select type="text" name="unit" class="form-control" id="unit" aria-describedby="unitHelp">
                    <option {{(isset($service) && $service->unit == "m2") ? 'selected' : ''}} value="m2">m2</option>
                    <option {{(isset($service) && $service->unit == "ml") ? 'selected' : ''}} value="ml">ml</option>
                    <option {{(isset($service) && $service->unit == "un") ? 'selected' : ''}} value="un">un</option>
                    <option {{(isset($service) && $service->unit == "vg") ? 'selected' : ''}} value="vg">vg</option>
                </select>

                <small id="unitHelp" class="form-text text-muted">Unidade ex. m2</small>
            </div>

            <div class="form-group">
                <label for="unit">Utilizar configuração da divisão?</label>

                <select type="text" name="quantity_calc" class="form-control" id="quantity_calc" aria-describedby="unitHelp">
                    <option {{(isset($service) && $service->quantity_calc == "false") ? 'selected' : ''}} value="false">Não</option>
                    <option {{(isset($service) && $service->quantity_calc == "Área Paredes") ? 'selected' : ''}} value="Área Paredes">Área Paredes</option>
                    <option {{(isset($service) && $service->quantity_calc == "Área Teto/Pavimento") ? 'selected' : ''}} value="Área Teto/Pavimento">Área Teto/Pavimento</option>
                    <option {{(isset($service) && $service->quantity_calc == "Pé Direito") ? 'selected' : ''}} value="Pé Direito">Pé Direito</option>
                    <option {{(isset($service) && $service->quantity_calc == "M. Linear") ? 'selected' : ''}} value="M. Linear">M. Linear</option>
                </select>

                <small id="unitHelp" class="form-text text-muted">Unidade ex. m2</small>
            </div>

            <div class="form-group">
                <label for="unit">Quantidade</label>
                <input type="number" value="{{isset($service->quantity) ? $service->quantity : '1'}}" name="quantity" class="form-control" id="quantity" aria-describedby="quantityHelp">
                <small id="quantityHelp" class="form-text text-muted">Quantidade</small>
            </div>

            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" value="{{isset($service->price) ? $service->price : '0'}}" name="price" class="form-control" id="price" aria-describedby="priceHelp">
                <small id="priceHelp" class="form-text text-muted">Preço do serviço</small>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Materiais</h5>
                </div>

                <div class="card-body">
                    <table id="tableMaterials" data-toggle="table" data-height="400" data-width="600" data-pagination="true" data-search="true" data-use-row-attr-func="true" data-reorderable-rows="true" data-buttons="buttons" data-url="{{isset($service->id) ? route('materialsByServiceId', ['id' => $service->id]) : ''}}" data-editable-url="{{isset($service->id) ? route('materialsByServiceId', ['id' => $service->id]) : ''}}">
                        <thead>
                            <tr data-class="las">
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id">ID</th>
                                <th data-field="title" data-editable="true">Nome</th>
                                <th data-field="supplier_title">Fornecedor</th>
                                <th data-field="unit_price" data-editable="true">Preço</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>

            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalTableMaterials">Adicionar materiais</button>
            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>
    </div>
</div>

@push('scripts')
<script src="/public/admin/js/libs/jquery.repeater.js"></script>
<script src="/public/admin/js/repeater.js"></script>
<script>
    var $materialsTableModal = $('#tableInModalMaterials'); // tabela na modal

    $(function() {
        $('#modalTableMaterials').on('shown.bs.modal', function() {
            $materialsTableModal.bootstrapTable('resetView')
        })
    });

    var $materialsInTableForm = $('#tableMaterials'); // tabela no form

    function buttons() {
        return {
            btnRemoveEvenRows: {
                'text': 'Remover',
                'icon': 'fa-trash',
                'event': () => {
                    removeSelections()
                },
                'attributes': {
                    'title': 'Remover selecionados'
                }
            }
        }
    }

    $materialsTableModal.bootstrapTable({
        onClickRow: function(row, e) {
            $('#tableMaterials').bootstrapTable('append', row);
            console.log(row, e);
        }
    });

    function removeSelections() {
        var ids = $.map($materialsInTableForm.bootstrapTable('getSelections'), function(row) {
            return row.id
        });

        $materialsInTableForm.bootstrapTable('remove', {
            field: 'id',
            values: ids
        })
    }

    $("form").submit(function(e) {
        var selections = $('#tableMaterials').bootstrapTable('getData');
        selections = selections.map(s => s.id);
        $('input[name=selections]').val(selections);
    });
</script>
@endpush

@endsection