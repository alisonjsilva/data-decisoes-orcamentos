<?php
$repeater_item = '';
$input_aux = '';
$to_show = '';
if (!isset($material)) {
    //dd($material);
    $repeater_item = "data-repeater-item";
} else {
    $input_aux = "materials[{$count_mt}]";
    $to_show = 'to_show';
}
?>
<div class="card-body {{$to_show}}" {{$repeater_item}}>
    <div class="row mb-2">
        <div class="col-3 p-1">Nome</div>
        <div class="col-2 p-1">Fornecedor</div>
        <div class="col-2 p-1">Status</div>
        <div class="col-1 p-1">Unidade</div>
        <div class="col-1 p-1">Qt.</div>
        <div class="col-1 p-1">Preço</div>
        <div class="col-1 p-1">Subtotal</div>
    </div>
    <div class="row mb-2">
        <div class="col-3  p-1">
            <input data-name="title" type="text" value="{{isset($material->title) ? $material->title : ''}}" name="{{isset($material) ? $input_aux.'[title]' : 'title'}}" class="form-control form-control-sm">
        </div>
        <div class="col-2 p-1">
            <input data-name="supplier_title" type="text" value="{{isset($material->supplier_title) ? $material->supplier_title : ''}}" name="{{isset($material) ? $input_aux.'[supplier_title]' : 'supplier_title'}}" class="form-control form-control-sm">
        </div>
        <div class="col-2 p-1">
            <select data-name="status" type="text" name="{{isset($material) ? $input_aux.'[status]' : 'status'}}" class="form-control form-control-sm">
                @foreach($status_list_materials as $status)
                <option {{(isset($material) && $material->status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-1 p-1">
            <input data-name="unit" type="text" value="{{isset($material->unit) ? $material->unit : ''}}" name="{{isset($material) ? $input_aux.'[unit]' : 'unit'}}" class="form-control form-control-sm">
        </div>
        <div class="col-1 p-1">
            <input data-name="quantity" value="{{isset($material->quantity) ? $material->quantity : ''}}" name="{{isset($material) ? $input_aux.'[quantity]' : 'quantity'}}" class="form-control form-control-sm quantity">
        </div>
        <div class="col-1 p-1">
            <input data-name="price" type="text" value="{{isset($material->price) ? $material->price : ''}}" name="{{isset($material) ? $input_aux.'[price]' : 'price'}}" class="form-control form-control-sm price">
        </div>

        <div class="col-1 p-1">
            <input data-name="subtotal" type="text" value="{{isset($material->subtotal) ? $material->subtotal : ''}}" name="{{isset($material) ? $input_aux.'[subtotal]' : 'subtotal'}}" class="form-control form-control-sm">
        </div>


        <input data-name="supplier_id" value="{{isset($material->supplier_id) ? $material->supplier_id : ''}}" type="hidden" name="{{isset($material) ? $input_aux.'[supplier_id]' : 'supplier_id'}}">
        <input data-name="type_id" value="{{isset($material->type_id) ? $material->type_id : ''}}" type="hidden" name="{{isset($material) ? $input_aux.'[type_id]' : 'type_id'}}">
        <input data-name="order_id" value="{{isset($material->order_id) ? $material->order_id : ''}}" type="hidden" name="{{isset($material->order_id) ? $input_aux.'[order_id]' : 'order_id'}}">
        <input data-name="service_id" value="{{isset($material->service_id) ? $material->service_id : ''}}" type="hidden" name="{{isset($material) ? $input_aux.'[service_id]' : 'service_id'}}">
        <input data-name="id" value="{{isset($material->id) ? $material->id : ''}}" type="hidden" name="{{isset($material) ? $input_aux.'[id]' : 'id'}}">

    </div>

    <div class="row mb-2">
        <div class="col-3 p-1">Descrição</div>
    </div>
    <div class="col-3 p-1">
        <textarea rows="3"  class="form-control form-control-sm" name="{{isset($material) ? $input_aux.'[description]' : 'description'}}">{{isset($material->description) ? trim($material->description) : ''}}</textarea>
    </div>


    <div class="row mb-2">
        <div class="col-1 p-1">Qt. final</div>
        <div class="col-1 p-1">Preço final</div>
        <div class="col-1 p-1">Subtotal. Final</div>
        <div class="col-2 p-1">Data de entrega</div>
        @if(isset($material->proposalService))
        <div class="col-2 p-1">Serviço</div>
        @endif
        <div class="col-1 p-1">Divisão</div>
        <div class="col-2 p-1">Categoria</div>
        <!-- <div class="col-1 p-1">Total</div> -->
        <div class="col-sm p-1">-</div>
    </div>
    <div class="row mb-2">
        <div class="col-1 p-1">
            <input data-name="final_quantity" type="text" value="{{isset($material->final_quantity) ? $material->final_quantity : ''}}" name="{{isset($material) ? $input_aux.'[final_quantity]' : 'final_quantity'}}" class="form-control form-control-sm final_quantity">
        </div>

        <div class="col-1 p-1">
            <input data-name="final_price" type="text" value="{{isset($material->final_price) ? $material->final_price : ''}}" name="{{isset($material) ? $input_aux.'[final_price]' : 'final_price'}}" class="form-control form-control-sm final_price">
        </div>
        <div class="col-1 p-1">
            <input data-name="final_subtotal" type="text" value="{{isset($material->final_subtotal) ? $material->final_subtotal : ''}}" name="{{isset($material) ? $input_aux.'[final_subtotal]' : 'final_subtotal'}}" class="form-control form-control-sm final_subtotal">
        </div>

        <div class="col-2 p-1">
            <?php
            $date = '';
            if (isset($material->delivery_date)) {
                $date = new DateTime($material->delivery_date);
                $date = $date->format('d-m-Y');
            }
            ?>
            <input data-name="delivery_date" type="text" value="{{$date}}" name="{{isset($material) ? $input_aux.'[delivery_date]' : 'delivery_date'}}" class="form-control form-control-sm" autocomplete="nope">
        </div>

        @if(isset($material->proposalService))
        <div class="col-2 p-1">
            <input type="text" disabled value="{{$material->proposalService->title}}" class="form-control form-control-sm">
        </div>

        @endif
        <div class="col-1 p-1">
            <input type="text" value="{{isset($material->tab_name) ? $material->tab_name : ''}}" name="{{isset($material) ? $input_aux.'[tab_name]' : 'tab_name'}}" class="form-control form-control-sm">
        </div>

        <div class="col-2 p-1">
            <input type="text" value="{{isset($material->category_title) ? $material->category_title : ''}}" name="{{isset($material) ? $input_aux.'[category_title]' : 'category_title'}}" class="form-control form-control-sm">
        </div>
        <!-- <div class="col-1 p-1">
            <input data-name="total" type="text" value="{{isset($material->total) ? $material->total : ''}}" name="{{isset($material) ? $input_aux.'[total]' : 'total'}}" class="form-control form-control-sm">
        </div> -->

        <div class="col-sm">
            <input class="btn btn-danger" data-repeater-delete type="button" value="Apagar" />
        </div>


    </div>
    <hr>
</div>
