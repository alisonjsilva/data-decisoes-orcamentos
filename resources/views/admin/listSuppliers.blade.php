@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')

<div class="card">
  <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/supplier/create" class="btn btn-primary">+ Adicionar</a>
    </nav>

    <table data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Telefone</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        @foreach ($suppliers as $supplier)
        <tr>
          <td>{{ $supplier->title }}</td>
          <td>{{ $supplier->phone }}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('supplier.edit', ['supplier' => $supplier->id]) }}"><i class="fas fa-edit"></i> Editar</a>

            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="float:right">

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