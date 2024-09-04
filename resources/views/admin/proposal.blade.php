@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<script>
  window.dataServices = '{{ $servicesJson }}';
</script>

<form>
    <div class="form-group">
        <select class="form-control" id="tipologia">
            <option>Tipologia</option>
            <option value="1">T1</option>
            <option value="2">T2</option>
            <option value="3">T3</option>
            <option value="4">T4</option>
            <option value="5">T5</option>
        </select>
        <small class="form-text text-muted">Escolha a tipologia do imóvel</small>
    </div>
    <div class="form-group">
        <label for="area">Área (m2)</label>
        <input class="form-control" type="text" placeholder="Insira a área em M2">
    </div>
    <div class="form-group">
        <select class="form-control" id="wcs">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <small class="form-text text-muted">Número de casas de banho</small>
    </div>
    <button class="btn btn-primary" id="btnCreateDivisions">Criar divisões</button>
</form>
<br>
<br>
<div class="container">
    <p>
        <button id="btn-add-tab" type="button" class="btn btn-primary pull-right">Adicionar divisão</button>
    </p> 
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist"></div>
    </nav>
    <div class="tab-content" id="nav-tabContent"></div>
</div>
<script>
    
</script>
@endsection