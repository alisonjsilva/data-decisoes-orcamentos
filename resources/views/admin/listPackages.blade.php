@extends('layouts.app')

@section('title', 'Serviços')

@section('content')
<?php //phpinfo(); ?>
<div class="card">
  <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/package/create" class="btn btn-primary">+ Adicionar</a>
    </nav>

    <table data-toggle="table"
    data-search="true"
    data-show-columns="true"
    data-pagination="true">
      <thead>
        <tr>
          <th>Título</th>
          <th>Descrição</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        @foreach ($packages as $package)
        <tr>
          <td>{{ $package->title }}</td>
          <td>{{ $package->description }}</td>
          <td>
          <a class="btn btn-primary" href="{{ route('package.edit', ['package' => $package->id]) }}"><i class="fas fa-edit"></i> Editar</a>
          
          <form action="{{ route('package.destroy', $package->id) }}" method="POST" style="float:right">

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