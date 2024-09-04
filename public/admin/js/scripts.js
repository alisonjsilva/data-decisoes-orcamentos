var _deletes = [];

function isEmptyOrSpaces(str) {
    return str === null || str.match(/^ *$/) !== null;
}

var button =
    '<button class="close" type="button" title="Remover divisão">×</button>';
var tabID = 1;

function resetTab() {
    var tabs = $("#nav-tab li:not(:first)");
    var len = 1;
    $(tabs).each(function (k, v) {
        len++;
        $(this)
            .find("a")
            .html("Tab " + len + button);
    });
    tabID--;
}

$(document).ready(function () {
    var indexDivision = 100;
    // Botão adicionar tabs
    $("#btn-add-tab").click(function () {
        var divisionName = $('#division-name').val();

        if (divisionName !== '') {
            var divisionId = divisionName.replace(/[^A-Z0-9]/ig, "-") + indexDivision;
            createTabs(divisionId, divisionName);
            $('#division-name').val('');
            indexDivision++;
            //$(".edit").click(editHandler);
        }
    });

    // Botão remover tabs
    $("#nav-tab").on("click", ".close", function () {
        var tabID = $(this).parents("a").attr("href");
        $(this).parents("a").remove();

        $(tabID).find('.remove-li').each(
            function () {
                var jobid = $(this).attr('data-jobid');
                if (jobid !== undefined) {
                    _deletes.push(jobid);
                }
            });

        $(tabID).remove();

        //display first tab
        var tabFirst = $("#nav-tab a:first");
        resetTab();
        tabFirst.tab("show");
    });

    var list = document.getElementById("nav-tab");
});

// Editar tabs
var editHandler = function () {
    var t = $(this);
    t.css("visibility", "hidden");
    $(this)
        .prev()
        .attr("contenteditable", "true")
        .focusout(function () {
            $(this).removeAttr("contenteditable").off("focusout");
            t.css("visibility", "visible");
        });
};

$(".edit").click(editHandler);

/* Adicionar divisões conforme drop */
$("#btnCreateDivisions").on("click", function (e) {
    e.preventDefault();
    $('#create-division').hide();
    var tipologia = $("#tipologia").val();
    var wcs = $("#wcs").val();
    //console.log(tipologia);
    //console.log(wcs);

    /* Criar divisões comuns */
    createTabs("cozinha-0", "Cozinha");
    createTabs("sala-0", "Sala");

    /* Criar quartos */
    for (let index = 0; index < tipologia; index++) {
        const element = tipologia;
        var id = "quarto-" + index;
        var title = "Quarto " + (index + 1);
        var content = title;
        createTabs(id, title);
    }

    /* Criar casas de banho */
    for (let index = 0; index < wcs; index++) {
        const element = wcs;
        var id = "wc-" + index;
        var title = "Casa de banho " + (index + 1);
        var content = title;
        createTabs(id, title);
    }

    /* Criar Hall */
    if ($('#with-hall:checked').length > 0) {
        createTabs("hall-0", "Hall de entrada");
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

function baseInputTextArea(liId, stringId, tabId) {
    return $('<textarea  class="form-control mt-2 li-job" rows="3">')
        .attr({
            'data-tabid': tabId,
            'data-tabindexid': liId,
            id: stringId + liId
        });
}

var liJobCounter = 0;

function addLiJob(tab, data, fromServer = false) {
    var jobListUl = $("#" + tab + " .jobs-list");

    var headerLiJobs = '<li id="headerLiJobs-' + tab + '" class="list-group-item"><div class="container"><div class="row"><div class="col"><i>Serviços</i></div><div class="col-1"><i>VG</i> <a href="javascript:;" onclick="checkall(\'' + tab + '\')"><i class="fas fa-check-double"></i></a></div><div class="col-1"><i>Un.</i></div><div class="col-2"><i>Quant.</i></div><div class="col-2"><i>Preço</i></div><div class="col-2"><i>Subtotal</i></div><div class="col-1"><i></i></div></div></div></li>';
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


    // Inicio implementar Inputs //

    var inputDescription = $(baseInputTextArea(liId, 'input-description-', tab).addClass('li-description').attr({
        name: 'description'
    }).val(data.description)).appendTo($liRowElement);

    var inputTitle = $('<div class="col">').append(baseInput(liId, 'input-title-', tab).addClass('li-title').attr({
        name: 'title',
    }).val(data.title))
        .append(inputDescription)
        .appendTo($liRowElement);


    var inputVg = $('<div class="col-1">').append($('<input/>')
        .attr({
            'type': 'checkbox',
            name: 'vg',
            checked: data.vg !== null && data.vg == 1 ? true : false, // == proposital to check int and string
            id: 'input-vg-' + liId,
            'data-tabid': tab
        })
    )
        .appendTo($liRowElement);




    //var inputTitle = $('<div class="col-2">').append(baseInput(liId, 'input-category-', tab).addClass('li-category').val(data.cat_name)).appendTo($liRowElement);
    var inputUnit = $('<div class="col-1">').append(baseInput(liId, 'input-unit-', tab).attr({
        name: 'unit',
        autocomplete: 'nope'
    }).addClass('li-quant').val(data.unit)).appendTo($liRowElement);

    // quantidade
    var quantity = data.quantity;

    if (!fromServer) {
        if (data.quantity_calc !== 'false') {
            var totalUn = 1;

            switch (data.quantity_calc) {
                case 'Área Paredes':
                    totalUn = parseFloat($('#input-area-paredes-' + tab).val());
                    break;
                case 'Área Teto/Pavimento':
                    totalUn = parseFloat($('#input-tectos-pavimento-' + tab).val());
                    break;
                case 'Pé Direito':
                    totalUn = parseFloat($('#input-pedireito-' + tab).val());
                    break;
                case 'M. Linear':
                    totalUn = parseFloat($('#input-linear-' + tab).val());
                    break;
            }

            if (totalUn > 0) {
                quantity = totalUn;
            }
        }

    }

    var subtotal = calcSubtotal(data.price, quantity);

    var inputQuant = $('<div class="col-2">').append(baseInput(liId, 'input-quant-', tab).attr({
        name: 'quantity',
        type: 'float',
        'min': 0,
        'pattern': '[0-9]'
    }).addClass('li-quant').val(quantity)).appendTo($liRowElement);

    // fim quantidade

    var inputPrice = $('<div class="col-2">').append(baseInput(liId, 'input-price-', tab).attr({
        name: 'price',
        type: 'number',
        'min': 0,
        'pattern': '[0-9]'
    }).addClass('li-price').val(data.price)).appendTo($liRowElement);

    var inputSubtotalPresentation = $('<div class="col-2">').append(baseInput(liId, 'input-subtotal-presentation-', tab).attr({
        name: 'subtotal-presentation',
        'disabled': 'disabled'
    }).addClass('li-subtotal').val(toEuro(subtotal))).appendTo($liRowElement);

    var inputSubtotal = $('<input/>').attr({
        'type': 'hidden',
        name: 'subtotal',
        id: 'input-subtotal-' + liId
    }).val(subtotal).appendTo($liRowElement);

    var inputCatId = $('<input/>').attr({
        'type': 'hidden',
        name: 'category_id'
    }).val(data.category_id).appendTo($liRowElement);

    var removeBtn = $('<div data-tabindexid="' + liId + '" data-tabid="' + tab + '" class="col-1 remove-li"><i><b><a href="javascript:;">x</a></b></i></div>')

    if (data.id !== undefined && fromServer === true) {
        var inputJobId = $('<input/>').attr({
            'type': 'hidden',
            name: 'id'
        }).val(data.id).appendTo($liRowElement);

        removeBtn.attr({
            'data-jobid': data.id
        });
    }

    // Fill service_id
    if (fromServer) {
        if (data.service_id === null) {
            $('<div class="col-1">').append(baseInput(liId, 'input-service_id-', tab).attr({
                name: 'service_id',
                type: 'number',
                'pattern': '[0-9]',
                'style' : 'background-color:yellow'
            })).appendTo($liRowElement);
        } else {
            var inputServiceId = $('<input/>').attr({
                'type': 'hidden',
                name: 'service_id'
            }).val(data.service_id).appendTo($liRowElement);
        }
    } else {
        var inputServiceId = $('<input/>').attr({
            'type': 'hidden',
            name: 'service_id'
        }).val(data.id).appendTo($liRowElement);
    }

    removeBtn.appendTo($liRowElement);

    calcSubtotalDivision(tab);
    //$('#input-quant-' + liId).change();
    liJobCounter++;
}

// Check All VG
function checkall(tabid) {
    $('input[data-tabid=' + tabid + '][type=checkbox]').each(function () {
        $(this).prop('checked', !$(this).prop('checked'));
    });

}

// click no botão remover trabalho
$(document).on('click', '.remove-li', function () {
    var tabId = $(this).attr('data-tabid');

    var deleteId = $(this).attr('data-jobid');
    if (deleteId !== undefined) {
        _deletes.push(deleteId);
    }

    $(this).closest('li').remove();
    calcSubtotalDivision(tabId);
});

// Calcular total comodo
//'sutotal-footer-tab-cozinha-0'
function calcSubtotalDivision(tabId) {
    //console.log($('[id^=input-subtotal-' + tabId + ']'))
    var subTotal = 0;
    $('[id^=input-subtotal-' + tabId + ']').each(function () {
        subTotal = parseInt($(this).val().replace(' €')) + subTotal;
    });
    $('#sutotal-footer-' + tabId).html(toEuro(subTotal));
}

// Calcular subtotal baseado na quantidade
$(document).on('change', '.li-quant', function (e) {
    var tabIndexId = $(this).attr('data-tabindexid');
    var tabId = $(this).attr('data-tabid');
    var quant = $(this).val();
    if (quant > -1) {
        var price = $('#input-price-' + tabIndexId).val();
        if (price > -1) {
            var subtotal = calcSubtotal(price, quant);
            $('#input-subtotal-presentation-' + tabIndexId).val(toEuro(subtotal));
            $('#input-subtotal-' + tabIndexId).val(subtotal);
            calcSubtotalDivision(tabId);
        }
    }
});

// Calcular subtotal baseado no preço
$(document).on('change', '.li-price', function (e) {

    var tabIndexId = $(this).attr('data-tabindexid');
    var price = $(this).val();
    var tabId = $(this).attr('data-tabid');

    if (price > -1) {
        var quant = $('#input-quant-' + tabIndexId).val();
        if (quant > -1) {
            var subtotal = calcSubtotal(price, quant);
            $('#input-subtotal-presentation-' + tabIndexId).val(toEuro(subtotal));
            $('#input-subtotal-' + tabIndexId).val(subtotal);
            calcSubtotalDivision(tabId);
        }
    }
});

function calcSubtotal(price, quant) {
    if (price > -1 && quant > -1) {
        var subtotal = (price * quant);
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

function toMoney(value) {
    if (value !== '' && typeof value === 'number') {
        return value.toLocaleString("pt-PT", {
            currency: "EUR",
            minimumFractionDigits: "2",
            currencyDisplay: "symbol"
        });
    }
}


$(document).on("click", ".addJob", function () {
    var tab = $(this).attr("data-tab");
    var elementToAppend =
        '<li><div class="container">' +
        '<div class="row" id="li-row-' + liJobCounter + '-' + tab + '"><div class="col-6"><input data-tabid="' + tab + liJobCounter + '" id="input-title-' + tab + liJobCounter + '" class="form-control basicAutoComplete" type="text" autocomplete="off"></div><div class="col"><input id="input-quantidade-' + tab + liJobCounter + '" class="form-control" type="text"/></div><div class="col"><input id="input-price-' + tab + liJobCounter + '" class="form-control" type="text" /></div></div></div></li>';
    $("#" + tab + " .jobs-list").append(elementToAppend);
    liJobCounter++;
    //initAutocomplete();
});

// ### Adicionar configuração as tabs ###
// ######################################
var createTabConfig = function (tabid, data) {

    if (data === undefined) {
        data = {};
    }
    //var formGroup = $('<div class="form-group">');
    var inputPeDireito = $('<div class="form-group"><label>Pé Direito:&nbsp;</label></div>').append($('<input class="form-control mr-sm-2 pedireito number_config" name="name" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Pé Direito', id: 'input-pedireito-' + tabid, 'data-tabid': tabid,
            type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.high_ceiling !== undefined ? data.high_ceiling : ''
        })).appendTo($('#tab-config-' + tabid));

    //-- novos
    var inputComprimento = $('<div class="form-group"><label>Comprimento:&nbsp;</label></div>').append($(' <input class="form-control mr-sm-2 comprimento number_config" name="comprimento" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Comprimento', id: 'input-comprimento-' + tabid, 'data-tabid': tabid,
            type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.width !== undefined ? data.width : ''
        }))
        //.appendTo('<div class="form-group"></div>')
        .appendTo($('#tab-config-' + tabid));

    var inputLargura = $('<div class="form-group mt-sm-2"><label>Largura:&nbsp;</label></div>').append($(' <input class="form-control mr-sm-2 largura number_config" name="largura" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Largura', id: 'input-largura-' + tabid, 'data-tabid': tabid, type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.height !== undefined ? data.height : ''
        })).appendTo($('#tab-config-' + tabid));

    var inputAreaTectosPavimento = $('<div class="form-group mt-sm-2"><label>Área Teto/Pavimento:&nbsp;</label></div>').append($(' <input class="form-control mr-sm-2 tectos-pavimento number_config" name="tectos-pavimento" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Area Tetos/Pavimento', id: 'input-tectos-pavimento-' + tabid, 'data-tabid': tabid,
            type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.ceiling_floor !== undefined ? data.ceiling_floor : ''
        })).appendTo($('#tab-config-' + tabid));

    var inputAreaParedes = $('<div class="form-group mt-sm-2"><label>Área Paredes:&nbsp;</label></div>').append($(' <input class="form-control mr-sm-2 area-paredes number_config" name="name" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Área Paredes', id: 'input-area-paredes-' + tabid, 'data-tabid': tabid,
            type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.walls !== undefined ? data.walls : ''
        })).appendTo($('#tab-config-' + tabid));

    var inputTotalMetros2 = $('<div class="form-group mt-sm-2"><label>Línear:&nbsp;</label></div>').append($(' <input class="form-control mr-sm-2 linear number_config" name="name" type="text" autocomplete="nope">')
        .attr({
            'placeholder': 'Linear', id: 'input-linear-' + tabid, 'data-tabid': tabid,
            type: 'float',
            'min': 0,
            'pattern': '[0-9]',
            value: data.linear !== undefined ? data.linear : ''
        })).appendTo($('#tab-config-' + tabid));
    // -- fim novos


    var btnCalc = $('<button class="btn btn-outline-primary mt-sm-2 btn-calcm2"><i class="fas fa-calculator"></i> Calcular</button>')
        .attr({ id: 'btn-calcm2-' + tabid, 'data-tabid': tabid })
        .appendTo($('#tab-config-' + tabid));

}

$(document).on('change', '.number_config', function () {
    var value = $(this).val().replace(/,/g, '.')
    $(this).val(parseFloat(value).toFixed(2));
    console.log(value)
})

$(document).on('click', '.btn-calcm2', function () {
    var tabid = $(this).attr('data-tabid');
    var pedireito = $('#input-pedireito-' + tabid).val();
    var linear = $('#input-linear-' + tabid).val();
    var comprimento = $('#input-comprimento-' + tabid).val();
    var largura = $('#input-largura-' + tabid).val();
    var linear = 0;

    // area pavimento/tectos e Linear
    if (comprimento > 0 && largura > 0) {
        var total_area_tectos_pavimento = comprimento * largura;
        total_area_tectos_pavimento = Math.round((total_area_tectos_pavimento + Number.EPSILON) * 100) / 100;
        $('#input-tectos-pavimento-' + tabid).val(total_area_tectos_pavimento.toFixed(2));
        linear = (comprimento * 2) + (largura * 2);
        linear = Math.round((linear + Number.EPSILON) * 100) / 100;
        $('#input-linear-' + tabid).val(linear.toFixed(2));
    }


    // area paredes
    if (comprimento > 0 && largura > 0 && pedireito > 0) {
        var total_area_paredes = linear * pedireito;
        total_area_paredes = Math.round((total_area_paredes + Number.EPSILON) * 100) / 100;
        $('#input-area-paredes-' + tabid).val(total_area_paredes.toFixed(2));
    }

    // if (pedireito > 0 && linear > 0) {
    // 	var total = pedireito * linear;
    // 	console.log(total)
    // 	$('#input-totalmetros2-' + tabid).val(total);
    // }
});

var createTabsIndex = 0;
var createTabs = function (id, title, server_id = 0, data) {
    var tabid = "tab-" + id;

    var nav = $(
        '<a class="nav-item nav-link" id="' + id + '" data-toggle="tab" href="#tab-' + id + '" role="tab" aria-controls="nav-' + id + '" aria-selected="false" data-title="' + title + '">' + title + ' <i class="fas fa-edit text-muted edit"></i> <button class="close" type="button" title="Remover ' + title + '">×</button></a>'
    );

    if (createTabsIndex === 0) {
        nav.addClass('active');
    }

    $("#nav-tab").append(nav);

    // Adicionar tables panels e tabela
    var panel = $('<div class="panelDivision tab-pane fade" data-serverid="' + server_id + '" id="' + tabid + '" data-navid="' + id + '"><table id="table' + id + '"></table></div>');

    if (createTabsIndex === 0) {
        panel.addClass('active');
        panel.addClass('show');
    }

    $("#nav-tabContent").append(panel);

    // Adicionar configuração tabs
    $("#nav-tabContent #" + tabid).append(
        '<div class="container mt-4 mb-4 form-inline" id="tab-config-' + tabid + '"></div>'
    );
    createTabConfig(tabid, data);

    // Adicionar lista de trabalhos
    $("#nav-tabContent #" + tabid).append(
        '<div class="container"><ul class="jobs-list list-group list-group-flush"></ul></div>'
    );

    $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-secondary" data-toggle="modal" data-target="#modalTable">Adicionar Trabalhos</button> ');

    // Botão adicionar por categoria
    $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-success" data-toggle="modal" data-target="#modalTableCategories">Adicionar por Categoria</button> ');

    // Botão adicionar Packs
    $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-success" data-toggle="modal" data-target="#modalTablePacks">Adicionar Pack</button> ');

    // Botão Salvar
    $("#" + tabid).append('<button type="button" data-tab="' + tabid + '" class="btn btn-success savePropose" data-toggle="modal">Salvar</button> ');

    // Botão Cancelar
    $("#" + tabid).append('<a type="button" data-tab="' + tabid + '" class="btn btn-danger cancel" href="/proposal">Cancelar</a> ');

    createTabsIndex++;
};

// tabela da modal
$('#tableInModal').bootstrapTable({
    onClickRow: function (row, e) {
        var id = $('.panelDivision.active').attr('id');
        addLiJob(id, row);
    }
});

// tabela da modal categorias
$('#tableInModalCategories').bootstrapTable({
    onClickRow: function (row, e) {
        var id = $('.panelDivision.active').attr('id');

        $.ajax({
            method: "GET",
            url: "/api/services/" + row.id
        })
            .done(function (services) {
                //console.log(msg)
                services.map(s => addLiJob(id, s))
            });
    }
});

// tabela da modal Packs
$('#tableInModalPacks').bootstrapTable({
    onClickRow: function (row, e) {
        var id = $('.panelDivision.active').attr('id');

        $.ajax({
            method: "GET",
            url: "/api/services/package/" + row.id
        })
            .done(function (services) {
                console.log(services)
                services.map(s => addLiJob(id, s))
            });
    }
});

$(document).on('click', '#create_order_btn', function () {
    $.ajax({
        method: "GET",
        url: "/api/order/createorder/" + $('input[name=proposal_id]').val(),
        dataType: 'JSON',
    })
        .done(function (result) {
            $.notify('<strong>' + result.order_id + '</strong> Encomenda criada com sucesso', {
                type: 'success',
                allow_dismiss: true,
            });

            let $btn = $('#create_order_btn');
            $btn.text('Ver encomenda');
            $btn.attr('href', '/order/' + result.order_id + '/edit');
            $btn.attr('id', '__');
            $btn.attr('target', '_blank');
        })
        .fail(function (error) {

            $.notify('<strong>Erro ao gravar </strong>', {
                type: 'danger',
                allow_dismiss: true,
                timer: 5000
            });
        });
});

// Salvar
$(document).on('click', '.savePropose', function () {
    var _index = 0;

    if (isEmptyOrSpaces($('input[name=name]').val())) {
        alert('Preencha o nome!');
        return;
    }
    var url = "/api/proposal/saveAjax";
    var first_save = true;
    var proposal = [];
    var tabs = [];
    var client = {};

    if ($('input[name=proposal_id]').val() !== undefined) {
        //url = "/api/proposal/updateAjax";
        first_save = false;
    }

    client.name = $('input[name=name]').val();
    client.address = $('input[name=address]').val();
    client.phone = $('input[name=phone]').val();
    client.obra = $('input[name=obra]').val();
    client.gestor = $('input[name=gestor]').val();
    client.prazo = $('input[name=prazo]').val();
    client.email = $('input[name=email]').val();
    client.status = $('select[name=status] option:selected').val();
    client.iva_id = $('select[name=general_iva] option:selected').val();
    client.notes = $('textarea[name=notes]').val();

    proposal.push(client);

    $('.panelDivision').each(function () {
        var tab = {};
        var jobslist = [];
        var tabid = $(this).attr('id');
        var navid = $(this).attr('data-navid');

        tab.id = $(this).attr('data-serverid');
        tab.tab_id = tabid;
        // get tab name
        //tab.name = $('#' + navid).attr('data-title');

        tab.proposal_id = null;
        tab.title = $('#' + navid).attr('data-title');
        tab.high_ceiling = $('#input-pedireito-' + tabid).val();
        tab.width = $('#input-comprimento-' + tabid).val();
        tab.height = $('#input-largura-' + tabid).val();
        tab.ceiling_floor = $('#input-tectos-pavimento-' + tabid).val();
        tab.walls = $('#input-area-paredes-' + tabid).val();
        tab.linear = $('#input-linear-' + tabid).val();

        $('li[data-tabid=' + tabid + ']').each(function () {
            var job = {};

            $(this).find('input, textarea').each(function () {
                if ($(this).attr('type') === 'checkbox') {
                    var checked = $(this).prop('checked');
                    job[$(this).attr('name')] = +checked;
                } else {
                    job[$(this).attr('name')] = $(this).val();
                    job['ord'] = _index;
                }

                job.proposal_id = -1;

                var _price = job['price'];
                if (_price === null || _price === '') {
                    job['price'] = 0;
                }

                var _quant = job['quantity'];
                if (_quant === null || _quant === '') {
                    job['quantity'] = 0;
                }

            });
            _index++;
            job.tabid = tab.tab_id;
            job.tab_name = tab.title;
            delete job['subtotal-presentation'];
            jobslist.push(job);
        });

        tab.jobs = jobslist;
        tabs.push(tab);
    });

    proposal.push(tabs);

    console.log(proposal);
    //return;
    var _data = {
        client,
        tabs,
        '_token': $('input[name=_token]').val(),
        id: $('input[name=proposal_id]').val(),
        deletes: _deletes
    }
    console.log("data", _data);

    //#### Save Jobs list data ###//
    var tabs_saved_count = 0;

    function redirectAfterSaves(proposal_id) {
        $.notify('<strong>Todos os dados foram salvos. Aguarde...</strong>', {
            type: 'warning',
            allow_dismiss: true,
            timer: 5000
        });
        setTimeout(function () {
            window.location.href = '/proposal/' + proposal_id + '/edit/';
        }, 2500);

    }

    var saveTabsWithJobs = function (proposal_id, tab) {
        $.ajax({
            method: "POST",
            url: "/api/proposal/updateAjax", //--> url update
            data: {
                client,
                tab,
                id: proposal_id,
                deletes: _deletes
            },
            dataType: 'JSON',
        })
            .done(function (result) {
                //$('.toast-success').toast('show');
                tabs_saved_count++;

                $.notify('<strong>' + tab.title + '</strong> Salvo com sucesso', {
                    type: 'success',
                    allow_dismiss: true,
                });

                if (tabs_saved_count === tabs.length) {
                    redirectAfterSaves(proposal_id);
                }
            })
            .fail(function (error) {

                //console.log(error);
                //$('.toast-error').toast('show');
                $.notify('<strong>Erro ao gravar ' + tab.title + '</strong> <br> Por favor, valide todos os campos nesta divisão', {
                    type: 'danger',
                    allow_dismiss: true,
                    timer: 5000
                });
            });
    }

    if (first_save) {
        $.ajax({
            method: "POST",
            url: "/api/proposal/saveAjax", //--> url de save
            data: {
                client,
                deletes: _deletes
            },
            dataType: 'JSON',
        })
            .done(function (proposal_id) {
                $.notify('<strong>Orçamento Salvo com sucesso</strong>', {
                    type: 'success',
                    allow_dismiss: true,
                });
                if (proposal_id > -1) {
                    tabs.forEach(tab => {
                        saveTabsWithJobs(proposal_id, tab);
                    });
                }
            })
            .fail(function (error) {
                console.log(error);
                //$('.toast-error').toast('show');
                $.notify('<strong>Erro ao gravar Orçamento</strong>', {
                    type: 'danger',
                    allow_dismiss: true,
                    timer: 5000
                });
            });
    } else {
        var proposal_id = $('input[name=proposal_id]').val()
        tabs.forEach(tab => {
            saveTabsWithJobs(proposal_id, tab);
        });
    }

});

$(function () {
    $(".jobs-list").sortable();
    $(".jobs-list").disableSelection();
});
