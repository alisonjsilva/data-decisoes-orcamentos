@extends('layouts.app')

@section('title', 'Serviços')

@section('content')

<div class="card">
  <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/service/create" class="btn btn-primary">+ Adicionar</a>
    </nav>

    <table data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
      <thead>
        <tr>
          <th>Título</th>
          <th>Categoria</th>
          <th>Descrição</th>
          <th>Preço</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        @foreach ($services as $service)
        <tr>
          <td>{{ $service->title }}</td>
          <td>{{ $service->cat_name }}</td>
          <td>{{ $service->description }}</td>
          <td>{{ $service->price }}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('service.edit', ['service' => $service->id]) }}"><i class="fas fa-edit"></i> Editar</a>

            <form action="{{ route('service.destroy', $service->id) }}" method="POST" style="float:right">

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