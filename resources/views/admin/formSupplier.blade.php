@extends('layouts.app')

@section('title', 'Fornecedor')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{isset($supplier) ? route('supplier.update', $supplier) : route('supplier.store')}}" method="POST">
            @if(isset($supplier))
            @method('put')
            <input type="hidden" value="{{$supplier->id}}" name="id" />
            @endif
            @csrf

            <div class="form-group">
                <label for="title">Nome</label>
                <input type="text" value="{{isset($supplier->title) ? $supplier->title : ''}}" name="title" class="form-control" id="title" aria-describedby="titleHelp">
                <small id="titleHelp" class="form-text text-muted">Fornecedor</small>
            </div>
            
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp">{{isset($supplier->description) ? $supplier->description : ''}}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Descrição do fornecedor</small>
            </div>

            <div class="form-group">
                <label for="supplier_address">Morada</label>
                <input type="text" value="{{isset($supplier->address) ? $supplier->address : ''}}" name="address" class="form-control" id="address" aria-describedby="addressHelp">
                <small id="addressHelp" class="form-text text-muted">Morada</small>
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text" value="{{isset($supplier->phone) ? $supplier->phone : ''}}" name="phone" class="form-control" id="phone" aria-describedby="phoneHelp">
                <small id="phoneHelp" class="form-text text-muted">Telefone</small>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-danger">Cancelar</a>

        </form>
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
</script>

@endpush

@endsection