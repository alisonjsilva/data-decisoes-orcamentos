<div id="modalTableMaterials" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Materiais</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tableInModalMaterials" data-toggle="table" data-height="400" data-width="600" data-pagination="true" data-search="true" data-url="/api/materials">
          <thead>
            <tr>
              <th data-field="id">ID</th>
              <th data-field="title">Nome</th>
              <th data-field="supplier_title">Fornecedor</th>
              <th data-field="unit_price">Preço</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>