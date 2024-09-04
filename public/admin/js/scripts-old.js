var button =
  '<button class="close" type="button" title="Remover divisão">×</button>';
var tabID = 1;

function resetTab() {
  var tabs = $("#nav-tab li:not(:first)");
  var len = 1;
  $(tabs).each(function(k, v) {
    len++;
    $(this)
      .find("a")
      .html("Tab " + len + button);
  });
  tabID--;
}

$(document).ready(function() {
  var indexDivision = 100;
  // Botão adicionar tabs
  $("#btn-add-tab").click(function() {
    var divisionName = $('#division-name').val();

    if (divisionName !== '') {
      var divisionId = divisionName.replace(/[^A-Z0-9]/ig, "-") + indexDivision;
      createTabs(divisionId, divisionName, divisionName);
      $('#division-name').val('');
      indexDivision++;
      //$(".edit").click(editHandler);
    }
  });

  // Botão remover tabs
  $("#nav-tab").on("click", ".close", function() {
    var tabID = $(this).parents("a").attr("href");
    $(this).parents("a").remove();
    $(tabID).remove();

    //display first tab
    var tabFirst = $("#nav-tab a:first");
    resetTab();
    tabFirst.tab("show");
  });

  var list = document.getElementById("nav-tab");
});

// Editar tabs
var editHandler = function() {
  var t = $(this);
  t.css("visibility", "hidden");
  $(this)
    .prev()
    .attr("contenteditable", "true")
    .focusout(function() {
      $(this).removeAttr("contenteditable").off("focusout");
      t.css("visibility", "visible");
    });
};

$(".edit").click(editHandler);

/* Adicionar divisões conforme drop */
$("#btnCreateDivisions").on("click", function(e) {
  e.preventDefault();
  $('#create-division').hide();
  var tipologia = $("#tipologia").val();
  var wcs = $("#wcs").val();
  //console.log(tipologia);
  //console.log(wcs);

  /* Criar divisões comuns */
  createTabs("cozinha-0", "Cozinha", "Cozinha");
  createTabs("sala-0", "Sala", "Sala");

  /* Criar quartos */
  for (let index = 0; index < tipologia; index++) {
    const element = tipologia;
    var id = "quarto-" + index;
    var title = "Quarto " + (index + 1);
    var content = title;
    createTabs(id, title, content);
  }

  /* Criar casas de banho */
  for (let index = 0; index < wcs; index++) {
    const element = wcs;
    var id = "wc-" + index;
    var title = "Casa de banho " + (index + 1);
    var content = title;
    createTabs(id, title, content);
  }

  /* Criar Hall */
  if ($('#with-hall:checked').length > 0) {
    createTabs("hall-0", "Hall de entrada", "Hall de entrada");
  }
});

// $('.basicAutoComplete').autoComplete({
//     resolverSettings: {
//         url: '/api/service'
//     }
// });

function baseInput(liId, stringId, tabId) {
  return $('<input class="form-control li-job" type="text">')
    .attr({
      'data-tabid': tabId,
      'data-tabindexid': liId,
      id: stringId + liId
    });
}

var liJobCounter = 0;

function addLiJob(tab, data) {
  var jobListUl = $("#" + tab + " .jobs-list");

  var headerLiJobs = '<li id="headerLiJobs-' + tab + '" class="list-group-item"><div class="container"><div class="row"><div class="col"><i>Serviços</i></div><div class="col-1"><i>Un.</i></div><div class="col-1"><i>Quant.</i></div><div class="col-2"><i>Preço</i></div><div class="col-2"><i>Subtotal</i></div><div class="col-1"><i></i></div></div></div></li>';
  //var footerLiJobs = '<div id="footerLiJobs-'+tab+'" class=""><div class="container"><div class="row"><div class="col"></div><div class="col-1"></div><div class="col-2"></div><div class="col-2"></div><div class="col-1"><i class="sutotal-footer-'+tab+'">123</i></div></div></div></div>';
  var footerLiJobs = '<div id="footerLiJobs-' + tab + '" class="d-flex align-items-end flex-column"><b><i id="sutotal-footer-' + tab + '"></i></b></div>'

  if ($('#headerLiJobs-' + tab).length === 0) {
    jobListUl.append(headerLiJobs);
  }

  if ($('#footerLiJobs-' + tab).length === 0) {
    jobListUl.after(footerLiJobs);
  }

  var liRowId = 'li-row-' + liJobCounter + '-' + tab;
  var liJobHtml = '<li class="list-group-item" data-tabid="' + tab + '"><div class="container"><div class="row" id="' + liRowId + '"></div></div></li>';
  jobListUl.append(liJobHtml);

  var $liRowElement = $('#' + liRowId);
  var liId = tab + liJobCounter;
  var subtotal = calcSubtotal(data.price, data.quantity);

  //var baseInput = baseInput();

  var inputTitle = $('<div class="col">').append(baseInput(liId, 'input-title-', tab).addClass('li-title').attr({
    name: 'title'
  }).val(data.title)).appendTo($liRowElement);
  //var inputTitle = $('<div class="col-2">').append(baseInput(liId, 'input-category-', tab).addClass('li-category').val(data.cat_name)).appendTo($liRowElement);
  var inputUnit = $('<div class="col-1">').append(baseInput(liId, 'input-unit-', tab).attr({
    name: 'unit',
    autocomplete:'nope'
  }).addClass('li-quant').val(data.unit)).appendTo($liRowElement);
  var inputQuant = $('<div class="col-1">').append(baseInput(liId, 'input-quant-', tab).attr({
    name: 'quantity',
    type: 'number',
    'min': 0,
    'pattern': '[0-9]'
  }).addClass('li-quant').val(data.quantity)).appendTo($liRowElement);
  var inputPrice = $('<div class="col-2">').append(baseInput(liId, 'input-price-', tab).attr({
    name: 'price',
    type: 'number',
    'min': 0,
    'pattern': '[0-9]'
  }).addClass('li-price').val(data.price)).appendTo($liRowElement);
  var inputSubtotal = $('<div class="col-2">').append(baseInput(liId, 'input-subtotal-', tab).attr({
    name: 'subtotal',
    'disabled': 'disabled'
  }).addClass('li-subtotal').val(subtotal)).appendTo($liRowElement);
  var inputCatId = $('<input/>').attr({
    'type': 'hidden',
    name: 'category_id'
  }).val(data.category_id).appendTo($liRowElement);
  var removeBtn = $('<div data-tabindexid="' + liId + '" data-tabid="' + tab + '" class="col-1 remove-li"><i><b><a href="javascript:;">x</a></b></i></div>').appendTo($liRowElement);

  calcSubtotalDivision(tab);
  liJobCounter++;
}

$(document).on('click', '.remove-li', function() {
  var tabId = $(this).attr('data-tabid');
  $(this).closest('li').remove();
  calcSubtotalDivision(tabId);
});

// Calcular total comodo
//'sutotal-footer-tab-cozinha-0'
function calcSubtotalDivision(tabId) {
  //console.log($('[id^=input-subtotal-' + tabId + ']'))
  var subTotal = 0;
  $('[id^=input-subtotal-' + tabId + ']').each(function() {
    subTotal = parseInt($(this).val().replace(' €')) + subTotal;
  });
  $('#sutotal-footer-' + tabId).html(toEuro(subTotal));
}

// Calcular subtotal baseado na quantidade
$(document).on('change', '.li-quant', function(e) {
  var tabIndexId = $(this).attr('data-tabindexid');
  var tabId = $(this).attr('data-tabid');
  var quant = $(this).val();
  if (quant > -1) {
    var price = $('#input-price-' + tabIndexId).val();
    if (price > -1) {
      $('#input-subtotal-' + tabIndexId).val(calcSubtotal(price, quant));
      calcSubtotalDivision(tabId);
    }
  }
});

// Calcular subtotal baseado no preço
$(document).on('change', '.li-price', function(e) {

  var tabIndexId = $(this).attr('data-tabindexid');
  var price = $(this).val();
  var tabId = $(this).attr('data-tabid');

  if (price > -1) {
    var quant = $('#input-quant-' + tabIndexId).val();
    if (quant > -1) {

      $('#input-subtotal-' + tabIndexId).val(calcSubtotal(price, quant));
      calcSubtotalDivision(tabId);
    }
  }
});

function calcSubtotal(price, quant) {
  if (price > -1 && quant > -1) {
    var subtotal = toEuro(price * quant);
    return subtotal;
  }

  return 0;
}

function toEuro(value) {
  if (value !== '' && typeof value === 'number') {
    return value.toLocaleString("pt-PT", {
      style: "currency",
      currency: "EUR",
      minimumFractionDigits: "2",
      currencyDisplay: "symbol"
    });
  }
}


$(document).on("click", ".addJob", function() {
  var tab = $(this).attr("data-tab");
  var elementToAppend =
    '<li><div class="container">' +
    '<div class="row" id="li-row-' + liJobCounter + '-' + tab + '"><div class="col-6"><input data-tabid="' + tab + liJobCounter + '" id="input-title-' + tab + liJobCounter + '" class="form-control basicAutoComplete" type="text" autocomplete="off"></div><div class="col"><input id="input-quantidade-' + tab + liJobCounter + '" class="form-control" type="text"/></div><div class="col"><input id="input-price-' + tab + liJobCounter + '" class="form-control" type="text" /></div></div></div></li>';
  $("#" + tab + " .jobs-list").append(elementToAppend);
  liJobCounter++;
  //initAutocomplete();
});

var createTabs = function(id, title, content) {
  var tabid = "tab-" + id;
  $("#nav-tab").append(
    $(
      '<a class="nav-item nav-link" id="' + id + '" data-toggle="tab" href="#tab-' + id + '" role="tab" aria-controls="nav-' + id + '" aria-selected="false" data-title="' + title + '">' + title + ' <i class="fas fa-edit text-muted edit"></i> <button class="close" type="button" title="Remover ' + title + '">×</button></a>'
    )
  );
  // Adicionar tables panels e tabela
  $("#nav-tabContent").append(
    '<div class="panelDivision tab-pane fade" id="' + tabid + '" data-navid="' + id + '"><table id="table' + id + '"></table></div>'
  );

  // $("#nav-tabContent #" + tabid).append(
  //   '<div class="card" id="card-' + tabid + '"><div calss="card-body"><input type="number"/></div></div>'
  // );

  // $("#nav-tabContent #" + tabid).append(
  //   '<div class="container"><div class="row"><div class="card" id="card-' + tabid + '"><div calss="card-body"><input type="number" placeholder="Pé direito"/></div></div></div></div>'
  // );

  // Adicionar lista de trabalhos
  $("#nav-tabContent #" + tabid).append(
    '<div class="container"><ul class="jobs-list list-group list-group-flush"></ul></div>'
  );

  // adicionar botões
  // $("#" + tabid).append(
  //   '<button id="btn-addjob-' + id + '" data-tab="' + tabid + '" type="button" class="btn btn-primary addJob m-1">+ Adicionar Linha</button>'
  // );

  $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-secondary" data-toggle="modal" data-target="#modalTable">Adicionar Trabalhos</button>');

  // Botão adicionar por categoria
  $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-success" data-toggle="modal" data-target="#modalTableCategories">Adicionar por Categoria</button>');

  // Botão Salvar
  $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-success savePropose" data-toggle="modal">Salvar</button>');


  // Tabela que irá receber valores
  $("#tableSelections" + id).bootstrapTable({
    columns: [{
        checkbox: true,
      },
      {
        field: "id",
        title: "Item ID",
      },
      {
        field: "title",
        title: "Nome",
      },
      {
        field: "unit",
        title: "Unidade",
      },
      {
        field: "price",
        title: "Preço",
      }
    ],
  });

  // Tabela com valores vindos do server
  //   $("#table" + id).bootstrapTable({
  //     pagination: true,
  //     search: true,
  //     locale: "pt-PT",
  //     url: "/api/service",
  //     //clickToSelect:true,
  //     columns: [{
  //         checkbox: true,
  //       },
  //       {
  //         field: "id",
  //         title: "Item ID",
  //       },
  //       {
  //         field: "title",
  //         title: "Nome",
  //       },
  //       {
  //         field: "unit",
  //         title: "Unidade",
  //       },
  //       {
  //         field: "price",
  //         title: "Preço",
  //       },
  //     ],
  //     onClickRow: function(row, e) {
  //       //var $tableSelections = $("#tableSelections" + id);

  //       //$tableSelections.bootstrapTable("append", row);
  //       addLiJob(id, row);
  //     },
  //   });

};

// tabela da modal
$('#tableInModal').bootstrapTable({
  onClickRow: function(row, e) {
    var id = $('.panelDivision.active').attr('id');
    addLiJob(id, row);
  }
});

// tabela da modal categorias
$('#tableInModalCategories').bootstrapTable({
  onClickRow: function(row, e) {
    var id = $('.panelDivision.active').attr('id');

    $.ajax({
        method: "GET",
        url: "/api/services/" + row.id
      })
      .done(function(services) {
        //console.log(msg)
        services.map(s => addLiJob(id, s))
      });
  }
});

// Salvar
$(document).on('click', '.savePropose', function() {
  var proposal = [];
  var tabs = [];
  var client = {};

  client.name = $('input[name=name]').val();
  client.address = $('input[name=address]').val();
  client.phone = $('input[name=phone]').val();
  
  proposal.push(client);

  $('.panelDivision').each(function() {
    var tab = {};
    var jobslist = [];
    var tabid = $(this).attr('id');
    var navid = $(this).attr('data-navid');

    tab.id = tabid;
    // get tab name
    tab.name = $('#' + navid).attr('data-title');

    $('li[data-tabid=' + tabid + ']').each(function() {
      var job = {};

      $(this).find('input').each(function() {
        job[$(this).attr('name')] = $(this).val();
        job.description = '...';
        job.proposal_id = -1;
      });
      job.tabid = tab.id;
      job.tab_name = tab.name;
      jobslist.push(job);
    });

    tab.jobs = jobslist;
    tabs.push(tab);    
  });
  
  proposal.push(tabs);

  console.log(proposal);
  //return;
  $.ajax({
      method: "POST",
      url: "/api/proposal/saveAjax",
      data: {
        client, tabs,
        '_token': $('input[name=_token]').val()
      },
      _token: $('input[name=_token]').val(),
      dataType: 'JSON',
    })
    .done(function(msg) {
      console.log(msg)
    });

});