@extends('layouts.app')
@section('title', 'Criar Orçamento')

@section('content')
@include('layouts.modalServices')
@include('layouts.modalCategories')
@include('layouts.modalPackages')
<?php //dd($iva); ?>
<?php //dd($proposal); ?>
<div class="card">
  <div class="card-header">
    @if(isset($proposal))
    <a class="btn btn-primary pull-right" href="{{ route('proposal.show', ['proposal' => $proposal->id]) }}">Ver Orçamento <i class="fas fa-file-alt"></i></a>
    @endif

    @if(isset($order))
    <a class="btn btn-primary pull-right" href="{{ route('order.edit', ['order' => $order->id]) }}">Ver Encomenda <i class="fas fa-file-alt"></i></a>
    @elseif(isset($proposal))
    <a class="btn btn-primary pull-right" id="create_order_btn" href="javascript:;">+ Criar Encomenda <i class="fas fa-file-alt"></i></a>
    @endif
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-6">
        <div id="client-data" class="card">
          <div class="card-header">Cliente</div>
          <div class="card-body">
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->name) ? $proposal->name : ''}}" name="name" type="text" placeholder="Nome" autocomplete="false" required>
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->address) ? $proposal->address : ''}}" name="address" type="text" placeholder="Morada" autocomplete="false">
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->phone) ? $proposal->phone : ''}}" name="phone" type="text" placeholder="Telefone" autocomplete="false">
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->obra) ? $proposal->obra : ''}}" name="obra" type="text" placeholder="Obra" autocomplete="false">
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->gestor) ? $proposal->gestor : ''}}" name="gestor" type="text" placeholder="Gestor" autocomplete="false">
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->prazo) ? $proposal->prazo : ''}}" name="prazo" type="text" placeholder="Prazo" autocomplete="false">
            </div>
            <div class="form-group">
              <input class="form-control" value="{{isset($proposal->email) ? $proposal->email : ''}}" name="email" type="text" placeholder="Email" autocomplete="false">
            </div>



            <div class="form-group">
              <label for="status">Status</label>
              <select type="text" name="status" class="form-control" id="status">
                    <option {{(isset($proposal) && $proposal->status == "Rascunho") ? 'selected' : ''}} value="Rascunho">Rascunho</option>
                    <option {{(isset($proposal) && $proposal->status == "Em Espera") ? 'selected' : ''}} value="Em Espera">Em Espera</option>
                    <option {{(isset($proposal) && $proposal->status == "Espera Revisão Valores") ? 'selected' : ''}} value="Espera Revisão Valores">Espera Revisão Valores</option>
                    <option {{(isset($proposal) && $proposal->status == "Enviado") ? 'selected' : ''}} value="Enviado">Enviado</option>
                    <option {{(isset($proposal) && $proposal->status == "Em andamento") ? 'selected' : ''}} value="Em andamento">Em andamento</option>
                    <option {{(isset($proposal) && $proposal->status == "Adjudicado") ? 'selected' : ''}} value="Adjudicado">Adjudicado</option>
                    <option {{(isset($proposal) && $proposal->status == "Fechado") ? 'selected' : ''}} value="Fechado">Fechado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="general_iva">IVA</label>
                <select type="text" name="general_iva" class="form-control" id="general_iva" aria-describedby="titleHelp">
                    @foreach($ivas as $iva)
                    <option {{(isset($iva) && isset($proposal) && $iva->id == $proposal->iva_id) ? 'selected' : ''}} value="{{$iva->id}}">{{$iva->title}}</option>
                    @endforeach
                </select>
                <small id="categoryHelp" class="form-text text-muted">Taxa de IVA</small>

            </div>

          </div>
        </div>
        <hr>

        @if(!isset($services) || count($services) == 0)
        <div class="card" id="create-division">
          <div class="card-header">Configuração da moradia</div>
          <div class="card-body">
            <div class="form-group">
              <label for="tipologia">Tipologia</label>
              <select class="form-control" id="tipologia">
                <option value="0">T0</option>
                <option value="1">T1</option>
                <option value="2">T2</option>
                <option value="3">T3</option>
                <option value="4">T4</option>
                <option value="5">T5</option>
              </select>
              <small class="form-text text-muted">Escolha a tipologia do imóvel</small>
            </div>
            <!-- <div class="form-group">
          <label for="area">Área (m2)</label>
          <input class="form-control" type="text" placeholder="Insira a área em M2">
      </div> -->
            <div class="form-group">
              <label for="wcs">Casas de banho</label>
              <select class="form-control" id="wcs">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
              <small class="form-text text-muted">Escolha o número de casas de banho</small>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="with-hall">
              <label class="form-check-label" for="with-hall">Hall de entrada?</label>
            </div>
            <button class="btn btn-primary" id="btnCreateDivisions">Criar divisões</button>
          </div>

        </div>
        @endif

      </div>
      <div class="col">
        <div id="add-extras-data" class="card">
          <div class="card-header">+</div>
          <div class="card-body">
            <div class="form-group">
              <input class="form-control" name="division-name" id="division-name" type="text" placeholder="Nome da divisão" autocomplete="nope">
            </div>
            <div class="form-group">

              <button id="btn-add-tab" type="button" class="btn btn-primary pull-right">Adicionar divisão</button>
            </div>

            <div class="form-group">

            <label for="notes">Notas</label>
              <textarea class="form-control" rows="5" name="notes" id="notes" autocomplete="nope">{{isset($proposal->notes) ? $proposal->notes : ''}}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist"></div>
    </nav>
    <div class="tab-content" id="nav-tabContent"></div>
  </div>

</div>


<div id="hidde-contents" style="display:none">
  <div class="form-group" id="input-div">
    <input class="form-control" name="name" type="text" id="input-field">
  </div>
</div>


@csrf

@if(isset($services))
<input type="hidden" name="proposal_id" value="{{$proposal->id}}" />

<div class="col align-center" id="loading-tabs-jobs">
  <i class="fas fa-spinner fa-spin fa-4x"></i>
</div>
@endif

@push('scripts')
<script src="/admin/js/scripts.js?v=23112021_16172"></script>
@endpush

@section('footer-scripts')
@if(isset($services))
<script>

  @if(isset($proposal->tabs))
    @foreach($proposal->tabs as $tab)
    createTabs('{{str_replace("tab-", "", $tab->tab_id)}}', '{{$tab->title}}', '{{$tab->id}}', @json($tab));
    @endforeach
  @endif
  //$('#create-division').hide();

  // @foreach($divisions as $division)
  // //createTabs('{{str_replace("tab-", "", $division->tabid)}}', '{{$division->tab_name}}', '');
  // createTabs('{{str_replace("tab-", "", $division->tabid)}}', '{{$division->tab_name}}', '');
  // @endforeach

  @if(isset($services))
  @foreach($services as $service)

  addLiJob('{{$service->tabid}}', @json($service), true);
  @endforeach
  @endif

  $('#loading-tabs-jobs').hide();
</script>
@endif
@endsection

@endsection
