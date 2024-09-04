@extends('layouts.app')

@section('title', 'Criar/Editar Pack')

@section('content')
@include('layouts.modalServices')

<div class="card">
    <div class="card-body">
        <form action="{{isset($package->id) ? route('package.update', $package) : route('package.store')}}" method="post">
            @if(isset($package->id))
            @method('put')
            <input type="hidden" value="{{$package->id}}" name="id" />            
            @endif
            @csrf

            <input type="hidden" name="selections"/>

            <div class="form-group">
                <label for="title">Nome</label>
                <input type="text" value="{{isset($package->title) ? $package->title : ''}}" name="title" class="form-control" id="title" aria-describedby="titleHelp">
                <small id="titleHelp" class="form-text text-muted">Nome do serviço</small>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp">{{isset($package->description) ? $package->description : ''}}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Descrição do serviço</small>
            </div>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalTable">Adicionar trabalhos</button>
            <button type="submit" id="save" class="btn btn-primary">Salvar</button>

        </form>

        <!-- <div id="toolbar">
            <button id="btnRemove" class="btn btn-secondary">Remover</button>
        </div> -->
        <table id="tableServicesPack" 
        data-toggle="table" 
        data-height="400" 
        data-width="600" 
        data-pagination="true" 
        data-search="true" 
        data-buttons="buttons"
        data-use-row-attr-func="true"
        data-reorderable-rows="true"
        data-url="{{isset($package->id) ? route('packageById', ['id' => $package->id]) : ''}}">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id">ID</th>
                    <th data-field="title">Nome</th>
                    <th data-field="cat_name">Categoria</th>
                    <th data-field="unit">Unidade</th>
                    <th data-field="price">Preço</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
<script>
    var $servicesTable = $('#tableInModal');
    var $servicesInPackTable = $('#tableServicesPack');

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

    $servicesTable.bootstrapTable({
        onClickRow: function(row, e) {
            $('#tableServicesPack').bootstrapTable('append', row);
            console.log(row, e);
        }
    });

    function removeSelections() {
        var ids = $.map($servicesInPackTable.bootstrapTable('getSelections'), function(row) {
            return row.id
        });

        $servicesInPackTable.bootstrapTable('remove', {
            field: 'id',
            values: ids
        })
    }

    $(document).on('click', '#save', function(e) {
        var selections = $('#tableServicesPack').bootstrapTable('getData');
        selections = selections.map(s => s.id);
        //selections = JSON.stringify(selections)
        $('input[name=selections]').val(selections);
    })
</script>
@endpush

@endsection