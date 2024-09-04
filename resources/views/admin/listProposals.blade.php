@extends('layouts.app')

@section('title', 'Orçamentos')

@section('content')

<div class="card">
  <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/proposal/create" class="btn btn-primary">+ Adicionar</a>
    </nav>

    <table data-toggle="table"
    data-search="true"
    data-show-columns="true"
    data-pagination="true">
      <thead>
        <tr>
          <th>#</th>          
          <th>Nome</th>
          <th>Telefone</th>
          <th>Status</th>
          <th>ID Orçamento</th>
          <th></th>
          
        </tr>
      </thead>
      <tbody>

        @foreach ($proposals as $proposal)
        <tr>
          <td>{{ $proposal->id }}</td>
          <td>{{ $proposal->name }}</td>
          <td>{{ $proposal->phone }}</td>
          <td>{{ $proposal->status }}</td>
          <td>ORC-00{{$proposal->id+110}}-{{date('Y', strtotime($proposal->created_at))}}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('proposal.edit', ['proposal' => $proposal->id]) }}"><i class="fas fa-edit fa-lg"></i> Editar</a> 
            <a class="btn btn-primary" href="{{ route('proposal.show', ['proposal' => $proposal->id]) }}"><i class="fas fa-file-alt fa-lg"></i> Ver</a>             

            <form action="{{ route('proposal.destroy', $proposal->id) }}" method="POST" style="float:right" >   

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