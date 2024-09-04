@extends('layouts.app')

@section('title', 'Criar Categoria')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{isset($category->id) ? route('category.update', $category) : route('category.store')}}" method="post">
            @if(isset($category))
            @method('put')
            <input type="hidden" value="{{$category->id}}" name="id" />
            @endif
            @csrf

            <div class="form-group">
                <label for="title">Nome</label>
                <input type="text" value="{{isset($category->title) ? $category->title : ''}}" name="title" class="form-control" id="title" aria-describedby="titleHelp">
                <small id="titleHelp" class="form-text text-muted">Nome do serviço</small>
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" class="form-control" id="description" aria-describedby="descriptionHelp">{{isset($category->description) ? $category->description : ''}}</textarea>
                <small id="descriptionHelp" class="form-text text-muted">Descrição do serviço</small>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>
    </div>
</div>

@endsection