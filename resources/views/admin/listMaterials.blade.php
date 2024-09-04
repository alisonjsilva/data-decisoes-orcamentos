@extends('layouts.app')

@section('title', 'Materiais')

@section('content')
<div class="card">
  <div class="card-body">
    <nav class="navbar navbar-light bg-light">
      <a href="/material/create" class="btn btn-primary">+ Adicionar</a>
    </nav>

    <table data-toggle="table" data-search="true" data-show-columns="true" data-pagination="true">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Fornecedor</th>
          <th>Serviços</th>
          <th>Preço</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        @foreach ($materials as $material)
        <?php
        $services = DB::table('services_materials')
          ->leftJoin('services', 'services.id', '=', 'services_materials.service_id')
          ->select('services.id', 'services.title')
          ->where('material_id', '=', $material->id)
          ->get();
        ?>
        <tr>
          <td>{{ $material->id }}</td>
          <td>{{ $material->title }}</td>
          <td>{{ $material->supplier_title }}</td>
          <td>
            @foreach($services as $service)
            <ul>
                @if(isset($service->id))
              <li><a href="{{route('service.edit', ['service' => $service->id])}}" target="_blank">{{$service->title}}</a></li>
              @endif
            </ul>
            @endforeach
          </td>
          <td>{{ $material->unit_price }}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('material.edit', ['material' => $material->id]) }}"><i class="fas fa-edit"></i> Editar</a>

            <form action="{{ route('material.destroy', $material->id) }}" method="POST" style="float:right">

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
