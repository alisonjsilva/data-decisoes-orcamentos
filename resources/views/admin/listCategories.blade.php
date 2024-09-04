@extends('layouts.app')

@section('title', 'Serviços')

@section('content')
<div class="card">
    <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/category/create" class="btn btn-primary">+ Adicionar</a>
    </nav>
    <table data-toggle="table"
    data-search="true"
    data-show-columns="true"
    data-pagination="true">
    <thead>
        <tr>
            <th>id</th>
            <th>Título</th>
            <th>Descrição</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->description }}</td>
            <td>
            <a class="btn btn-primary" href="{{ route('category.edit', ['category' => $category->id]) }}"><i class="fas fa-edit"></i></a> Editar
            
            
            <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="float:right">

              @csrf
              @method('DELETE')

              <button type="submit" class="btn btn-danger" onclick="return confirm('Quer mesmo apagar?')"><i class="fas fa-trash fa-lg"></i> Apagar</button>
            </form>

            </td>

        </tr>
        @endforeach
    </tbody>
</table>

    </div>
</div>

@endsection