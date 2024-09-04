@extends('layouts.app', ['title' => 'Orçamento: ' . $proposal->name])

<!-- @section('title', 'Page Title') -->

@section('content')

    <?php
    $category = '';
    $division = '';
    $index_cat = 1;
    $init_loop_in_cat = true; // quando entra em cada categoria tem que ser true para corrigir o erro de não meter a divisão.
    $index_category = 1.0;
    $index_item = 0;

    $i_cat = 0;
    ?>
    <div class="container" id="main">
        <div class="card-header" id="apresentacao">
            <!-- <img src="/admin/img/fundo-data-decisoes.jpg" width="100%" alt=""> -->
            <div class="apresentacao_header" style="height:370px"></div>
            <div class="apresentacao_texto">
                <h1 style="color:orange"><b>Apresentação</b></h1>
                <div>
                    <p>Exmo.: Sr. Sra.:</p>
                    <p>A empresa JFS Construções, nasceu em 2003,Assumindo o seu nome para DataDecisões lda em
                        2015, destinando-se a actuar o ramo da construção civil, sendo actualmente uma sociedade de
                        referência no ramo na reabilitação, remodelação e impermeabilizações de edifícios, vivendas e
                        jardins.</p>
                    <p>Oferecemos aos nossos clientes um acompanhamento técnico especializado desde o desenho
                        gráfico, escolhas de materiais com um variado leque de catálagos, oferecendo todo o apóio ate
                        respectiva finalização da obra.</p>

                    <p>Estamos neste mercado com o intuito de satisfazer nossos clientes, para isto ouvimos suas idéias
                        formando parcerias sólidas e duradouras.
                        A nossa imagem de marca é a eficiência, qualidade e rigor.
                        Caso pretenda realizar sua obra, estaremos ao seu dispor para ajudar a concretizá-la,
                        do interesse do cliente</p>

                    <h3><b>Áreas de actuação</b></h3>
                    <p>Remodelação de vivendas e apartamentos ,escritórios e espaços comerciais,
                        Pintura de exteriores e interiores de vivendas e edifícios.
                        Algumas de nossas especialidades:</p>
                    <p>Carpintaria: Parket, soalho flutuantes, deks, afagamentos, cozinhas sob medidas.
                        Caixilharias em alumínio ou pvc, portas, portões e escadas em aço.</p>
                </div>
                <div id="apresentacao_clientes" style="height:600px">
                    <h5><b>Alguns de Nossos Clientes:</b></h5>
                </div>
                <div id="apresentacao_orcamento_gratis">

                </div>
            </div>
        </div>

        <div id="proposta">
            <div class="logo_proposta_bg">
                <img src="/admin/img/logo-fundo-data.jpg" alt="">
            </div>
            <div class="proposta_texto" style="min-height:400px">
                <h4><b>Cliente: {{ $proposal->name }}</b></h4>
                <br><br><br>
                <h2>PROPOSTA DE ORÇAMENTO: ORC-00{{ $proposal->id + 110 }}-{{ date('Y') }}</h2>
                <p>Sumário:</p>
                <p>Caros Srs.(as),</p>
                <p>Junto remetemos proposta de orçamento para os trabalhos solicitados por V. Exas, no
                    qual encontram-se incluídos os seguintes documentos:
                <ul>
                    <li>Caderno de Encargos</li>
                    <li>Condições Gerais</li>
                </ul>
                </p>

                <p>Estamos a inteira disposição para qualquer esclarecimento que seja necessário,
                    reiterando nosso total comprometimento e interesse na execução da presente proposta
                    de orçamento.</p>

                <p>Com o nossos Melhores Cumprimentos,</p>

                <p>Director</p>
                <p>Fernando Silva</p>
            </div>
        </div>


        <div class="card">
            <div class="card-header btns-actions">
                <a class="btn btn-primary pull-right"
                    href="{{ route('proposal.edit', ['proposal' => $proposal->id]) }}">Editar <i
                        class="fas fa-edit"></i></a>

                <a class="btn btn-primary pull-right" onclick="printHtml();" href="javascript:;">Imprimir <i
                        class="fas fa-edit"></i></a>
            </div>
            <!-- <div class="card-header">
                                    Cliente: {{ $proposal->name }} <br />
                                    Telefone: {{ $proposal->phone }} <br />
                                    Morada: {{ $proposal->address }} <br />
                                    Obra: {{ $proposal->obra }} <br />
                                    Gestor: {{ $proposal->gestor }} <br />

                                </div> -->


            <div class="card-body" id="card-table">

                <table id="table" data-toggle="table" data-show-footer="true">
                    <thead class="thead">
                        <tr>
                            <th>#</th>
                            <th class="table-header-client-info">
                                <div id="text-table-header" style="font-weight: normal;">
                                    Cliente: <i><b>{{ $proposal->name }}</b></i> <br />
                                    Telefone: {{ $proposal->phone }} <br />
                                    Email: {{ $proposal->email }} <br />
                                    Morada: {{ $proposal->address }} <br />
                                    Obra: {{ $proposal->obra }} <br />
                                    Gestor: {{ $proposal->gestor }} <br />
                                </div>
                                <hr>
                                <br>Descrição dos trabalhos

                            </th>
                            <th>Un.</th>
                            <th>Quant.</th>
                            <th>Valor Unit. <br>Euros</th>
                            <th>

                                <img src="/admin/img/logo_redondo.jpg" alt="Data Decisões" width="90%;">
                                <div style="position: relative; min-height:140px;min-width:90px;">

                                </div>
                                Valor Final <br>Euros
                            </th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                                            <tr>
                                                <th colspan="6">Parque Industrial Alto do Outeiro, Armazém D, 2785-653 - São Domingos de Rana</th>
                                            </tr>
                                        </tfoot> -->
                    <tbody>
                        @foreach ($categories as $category)

                            <tr class="table-active">
                                <td>{{ $index_category }}</td>
                                <td><b>{{ $category[0]->category->title }}</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b><i>{{ number_format($categories_sum[$category[0]->category->id], 2) }} €</i></b>
                                </td>
                            </tr>
                            <?php

                            $init_loop_in_cat = true;

                            $index_item = $index_category;
                            $index_category++;
                            ?>

                            @foreach ($category->sortBy('tab_name')->sortBy('ord') as $service)
                                <?php $index_item = $index_item + 0.01; ?>

                                <!-- Add Division Name -->
                                <!-- $init_loop_in_cat -> Primeiro loop dentro da categoria -->
                                @if ($division !== $service->tab_name || $init_loop_in_cat === true)
                                    <tr class="table-normal">
                                        <td></td>
                                        <td><b><i>{{ $service->tab_name }}</i></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $init_loop_in_cat = false; ?>
                                @endif

                                <?php
                                // Valores Globais
                                if ($service->vg !== null && $service->vg == 1) {
                                    $service->unit = 'Vg';
                                    $service->price = $service->subtotal;
                                    $service->quantity = 1;
                                }

                                ?>
                                <tr class="table-normal">
                                    <td>{{ $index_item }}</td>
                                    <td>{{ !is_null($service->description) && !empty($service->description) ? $service->description : $service->title }}
                                    </td>
                                    <td>{{ $service->unit }}</td>
                                    <td>{{ $service->quantity }}</td>
                                    <td>{{ number_format($service->price, 2) }} €</td>
                                    <td>{{ number_format($service->subtotal, 2) }} €</td>

                                </tr>

                                <?php $category = $service->category->title; ?>
                                <?php $division = $service->tab_name; ?>

                            @endforeach

                            @if ($loop->last)
                                <?php
                                $total_iva = 0;
                                // calc percentage
                                $percentage_iva = intval($iva->value);

                                if ($percentage_iva > 0) {
                                    //Convert our percentage value into a decimal.
                                    $total_iva = ($percentage_iva / 100) * $total;
                                }
                                ?>

                                <tr class="table-active">
                                    <td colspan="5">
                                        <b>TOTAL GLOBAL S/IVA</b>
                                    </td>
                                    <td><b>{{ number_format($total, 2) }} €</b></td>
                                </tr>
                                @if ($percentage_iva > 0)
                                    <tr class="table-active">
                                        <td colspan="5">
                                            <b>TOTAL GLOBAL {{ $iva->title }}</b>
                                        </td>
                                        <td><b>{{ number_format($total + $total_iva, 2) }} €</b></td>
                                    </tr>
                                @endif
                            @endif

                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-footer">
                            <td colspan="6">
                                Grupo Data Decisões - Manutenção, Remodelação e Construção<br>
                                RParque Industrial Alto do Outeiro, Armazém D, 2785-653 - São Domingos de Rana<br>
                                Phone.: +351 913 770 541 +351 961 025 570<br>
                                Website: www.datadecisoes.pt<br>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- <footer style="position: fixed;bottom: 0px;" class="col-xs-12">
                            <div id="pageselectorButtonContainr" class="col-xs-6">
                                <button id="page-selector-button-control" type="button" disabled=""><img id="page-selector-button-control-image" src="images/extreme-left.png"></button>
                                <button id="page-selector-button-control" type="button" disabled=""><img id="page-selector-button-control-image" src="images/arrow-left.png"></button>
                                <button id="page-selector-button-control" type="button" disabled=""><img id="page-selector-button-control-image" src="images/arrow-right.png"></button>
                                <button id="page-selector-button-control" type="button" disabled=""><img id="page-selector-button-control-image" src="images/extreme-right.png"></button>
                            </div>
                            <div class="pager-control col-xs-6 pull-right">
                                <label>Page</label>
                                <input accept="number" id="pagetextfield" type="text" ng-reflect-model="1" class="ng-untouched ng-pristine ng-valid">
                                <label>of</label>
                                <label> </label>
                                <label>1</label>
                            </div>
                        </footer> -->

        <div id="condicoes">
            <h4><b>Condições gerais</b></h4>
            <div class="proposta_texto">
                <p>A adjudicação da presente proposta implica a aceitação das cláusulas seguintes:</p>
                <ul>
                    <li>1. Os trabalhos a executar, com início e prazo de execução a acordar entre ambas as partes, serão
                        efetuados
                        de acordo com o orçamento discriminativo apresentado, incluindo fornecimento e aplicação dos
                        materiais
                        necessários ao seu bom acabamento, de acordo com os processos de trabalho mencionados, assim como
                        transporte de entulho a vazadouro.</li>
                    <li>2. Para a realização dos trabalhos, pode a Datas Decisões Lda contratar livremente outras empresas,
                        em
                        regime de subempreitada, sem consentimento expresso do Dono de Obra.</li>
                    <li>3. É da nossa responsabilidade a criação de todas as condições de segurança, na área da obra e zonas
                        envolventes, para a boa execução dos trabalhos, sendo importante a colaboração do dono de obra,
                        nomeadamente no que diz respeito ao desimpedimento de zonas e reduzindo a circulação de pessoas ao
                        mínimo indispensável. OBS.: Seguro de Acidentes de Trabalho na Companhia Ocidental Seguros - Apólice
                        Nº
                        AT78537241; Seguro de Responsabilidade Civil na Ocidental Seguros.</li>
                    <li>4. Os preços da proposta apresentada são acrescidos do IVA à taxa legal em vigor, ou em regime de
                        autoliquidação no caso do cliente ser sujeito passivo de IVA.</li>
                    <li>5. Qualquer alteração à proposta adjudicada, necessária à boa execução da obra, será faturada
                        mediante
                        orçamento específico enviado para o efeito, em aditamento ao presente, ou será cobrada a 17,50 € x
                        homem
                        x hora, com prévia aceitação por parte do dono de obra.</li>
                    <li>6. Será da responsabilidade do Dono de Obra o fornecimento de energia elétrica, água e local para
                        armanezamento dos materiais necessários à execução dos trabalhos previstos.</li>
                    <li>7. A validade do orçamento: 30 dias.</li>
                    <li>8. Início e prazo de execução: {{ isset($proposal->prazo) ? $proposal->prazo : 'A acordar' }}
                    </li>
                    <li>9. O pagamento dos valores acordados deverá ser efectuado da seguinte forma:</li>
                    <li>a. Adjudicação dos trabalhos: 30%</li>
                    <li>a. Restante: A Combinar</li>
                    <li>10. Os valores apresentados são válidos na totalidade para a adjudicação integral da proposta,
                        podendo
                        esta ser objeto de revisão mediante a intenção de uma adjudicação parcial.</li>
                </ul>

            </div>

        </div>
        <div id="condicoes_imposto" class="condicoes_imposto">
            <h4><b>Condições gerais (Impostos)</b></h4>
            <div class="proposta_texto">

                <ul>
                    <li>1. Condições para aplicação de IVA à taxa reduzida (6%)</li>
                    <li>1.a) Em mão de obra e materiais, para empreitadas realizadas em áreas de reabilitação urbana, ao
                        abrigo da
                        verba 2.23 da lista I, anexa ao código do IVA.</li>
                    <li>1.b) Na mão de obra, para empreitadas de remodelação, reparação ou conservação de imóveis afetos à
                        habitação, ao abrigo da verba 2.27 da lista I, anexo ao Código do IVA. Em materiais, aplica-se IVA à
                        taxa
                        normal (23%), quando o valor correspondente seja superior à 20% do valor total da empreitada, sendo
                        inferior
                        poderá ser aplicado à taxa reduzida (6%) no valor total da empreitada.</li>
                    <li>2.C ondições para aplicação da inversão do sujeito passivo (0%)</li>
                    <li>2. a) Sendo empreitadas de remodelação, reparação ou conservação de imóveis realizadas para sujeitos
                        passivos de IVA, poderá aplicar-se a inversão do sujeito passivo, sendo portanto IVA autoliquidação.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function printHtml() {

                window.print();
            }
        </script>
    @endpush

@endsection
