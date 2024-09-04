@extends('layouts.app')

@section('title', 'Material')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($material) ? route('material.update', $material) : route('material.store') }}"
                method="POST">
                @if (isset($material))
                    @method('put')
                    <input type="hidden" value="{{ $material->id }}" name="id" />
                @endif
                @csrf

                <div class="form-group">
                    <label for="title">Nome</label>
                    <input type="text" value="{{ isset($material->title) ? $material->title : '' }}" name="title"
                        class="form-control" id="title" aria-describedby="titleHelp">
                    <small id="titleHelp" class="form-text text-muted">Nome do material</small>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea name="description" class="form-control" id="description"
                        aria-describedby="descriptionHelp">{{ isset($material->description) ? $material->description : '' }}</textarea>
                    <small id="descriptionHelp" class="form-text text-muted">Descrição do serviço</small>
                </div>

                <div class="form-group">
                    <label for="type_id">Tipo</label>
                    <select type="text" name="type_id" class="form-control" id="type_id"
                        aria-describedby="type_idHelp">
                        @foreach ($types as $type)
                            <option {{ isset($material) && $material->type_id == $type->id ? 'selected' : '' }}
                                value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="supplier_title">Fornecedor</label>
                    <input id="supplier" type="text"
                        value="{{ isset($material->supplier->title) ? $material->supplier->title : '' }}"
                        name="supplier_title" class="form-control" id="title" aria-describedby="titleHelp">
                    <small id="titleHelp" class="form-text text-muted">Fornecedor</small>
                </div>

                <div class="form-group">
                    <label for="unit">Unidade</label>

                    <select type="text" name="unit" class="form-control" id="unit" aria-describedby="unitHelp">
                        @foreach ($units as $unit)
                            <option {{ isset($material) && $material->unit == $unit->title ? 'selected' : '' }}
                                value="{{ $unit->title }}">{{ $unit->title }}</option>
                        @endforeach
                    </select>

                    <small id="unitHelp" class="form-text text-muted">Unidade ex. m2</small>
                </div>

                <div class="form-group">
                    <label for="unit">Quantidade Referência</label>
                    <input type="float" min="0" value="{{ isset($material->quantity) ? $material->quantity : '1' }}"
                        name="quantity" class="form-control number_config" id="quantity" aria-describedby="quantityHelp">
                    <small id="quantityHelp" class="form-text text-muted">Quantidade</small>
                </div>

                <div class="form-group">
                    <label for="unit">Unidade Referência</label>
                    <select type="text" name="unit_value" class="form-control" id="unit_value"
                        aria-describedby="unit_valueHelp">
                        @foreach ($units as $unit)
                            <option {{ isset($material) && $material->unit_value == $unit->title ? 'selected' : '' }}
                                value="{{ $unit->title }}">{{ $unit->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Preço Referência</label>
                    <input type="decimal" value="{{ isset($material->price) ? $material->price : '0' }}" name="price"
                        class="form-control" id="price" aria-describedby="priceHelp">
                    <small id="priceHelp" class="form-text text-muted">Preço</small>
                </div>

                <div class="form-group">
                    <label for="unit_price">Preço Final</label>
                    <input type="decimal" value="{{ isset($material->unit_price) ? $material->unit_price : '0' }}"
                        name="unit_price" class="form-control" id="unit_price" aria-describedby="priceHelp">
                    <small id="unit_priceHelp" class="form-text text-muted">Preço Unidade</small>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('material.index') }}" class="btn btn-danger">Cancelar</a>

            </form>
            <hr />
            @if (isset($material) && isset($material->services))
            @foreach ($material->services as $service)
                <ul>
                    <li>{{ $service->title }}</li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')

    <script src="/public/admin/js/libs/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
    <link rel="stylesheet" href="/public/admin/js/libs/easyautocomplete/easy-autocomplete.min.css">

    <script>
        var options = {
            url: function(phrase) {
                return "/public/api/suppliers?q=" + phrase;
            },

            getValue: "title",
            requestDelay: 500,
            maxNumberOfElements: 10,
            placeholder: "Digite o nome do Fornecedor"
        };

        $("#supplier").easyAutocomplete(options);

        $(document).on('change', '.number_config', function() {
            var value = $(this).val().replace(/,/g, '.')
            $(this).val(parseFloat(value).toFixed(2));
            console.log(value)
        })

    </script>

@endpush

@endsection
