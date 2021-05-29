<div class="menu">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="active">
                        <a href="#menu">
                            <i class="iconsminds-three-arrow-fork"></i> Menu
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sub-menu">
            <div class="scroll">
                <ul class="list-unstyled" data-link="menu" id="menuTypes">
                    <li id="menuPainel">
                    <a href="{{BASE}}{{empresa.link_site}}/admin" class="primaryMenu">
                            <span class="iconsminds-home iconeMenu"></span>
                            <span class="d-inline-block">Painel</span>
                        </a>
                    </li>
                    {% if nivelUsuario == 0 %}
                        {% if planoAtivo > 1 %}
                        <li id="menuCaixa">
                            <a href="#" data-toggle="collapse" data-target="#collapseCaixaTypes" aria-expanded="true"
                                aria-controls="collapseCaixaTypes" class="primaryMenu rotate-arrow-icon collapsed">
                                <span class="iconsminds-digital-drawing iconeMenu"></span> <span class="d-inline-block"> Fluxo de Caixa</span>
                                <i class="simple-icon-arrow-down iconAcao"></i>
                            </a>
                            <div id="collapseCaixaTypes" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                                <span class="triangulo-top"></span>
                                <ul class="list-unstyled inner-level-menu">
                                    <li id="caiVg">
                                        <a href="{{BASE}}{{empresa.link_site}}/admin/caixa/visao-geral">
                                            <span class="d-inline-block">Visão Geral</span>
                                        </a>
                                    </li>
                                    <li id="caiRel">
                                        <a href="{{BASE}}{{empresa.link_site}}/admin/caixa/relatorio" >
                                            <span class="d-inline-block">Relatórios</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {% endif %}
                    {% endif %}

                    <li id="menuPedido">
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuTypes" aria-expanded="true"
                           aria-controls="collapseMenuTypes" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="iconsminds-shop-4 iconeMenu"></span> <span class="d-inline-block"> Pedidos Delivery</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseMenuTypes" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                            <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                                <li id="subPn">
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/pedido/novo">
                                        <span class="d-inline-block"><strong>Adicionar Pedido</strong></span>
                                    </a>
                                </li>
                                <li id="subPd">
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos" >
                                        <span class="d-inline-block"><strong>Pedidos de Hoje</strong></span>
                                    </a>
                                </li>
                                {% if nivelUsuario == 0 %}
                                {% if planoAtivo > 1 %}
                                <li id="subPf">
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos-finalizados">
                                        <span class="d-inline-block"><strong>Todos Pedidos</strong></span>
                                    </a>
                                </li>
                               
                                {% endif %}
                                {% endif %}
                            </ul>
                        </div>
                    </li>
                    {% if nivelUsuario == 0 %}
                    <li id="menuMotoboys">
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuMotoboys" aria-expanded="true"
                            aria-controls="collapseMenuMotoboys" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="simple-icon-plane iconeMenu"></span> <span class="d-inline-block">Motoboys</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseMenuMotoboys" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                            <li id="subMt">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/motoboys" >
                                    <span class="d-inline-block"><strong>Motoboys</strong></span>
                                </a>
                            </li>
                            <li id="subEn">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/entregas">
                                    <span class="d-inline-block"><strong>Entregas</strong></span>
                                </a>
                            </li>
                            </ul>
                        </div>
                    </li>
                    
                    
                    {% endif %}
                    <li id="menuProdutos">
                        <a href="#" data-toggle="collapse" data-target="#collapseProdutos" aria-expanded="true"
                            aria-controls="collapseProdutos" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="iconsminds-cash-register-2 iconeMenu"></span> <span class="d-inline-block">Produtos</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseProdutos" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                            <li id="subProd">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produtos">
                                    <span class="d-inline-block"><strong>Todos os Produtos</strong></span>
                                </a>
                            </li>
                            
                            <li id="subProdA">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-adicionais">
                                    <span class="d-inline-block"><strong>Adicionais</strong></span>
                                </a>
                            </li>
                            
                            <li id="subSabores">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-sabores">
                                    <span class="d-inline-block"><strong>{{preferencias.sabores()}}</strong></span>
                                </a>
                            </li>
                            <li id="subCat">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">
                                    <span class="d-inline-block"><strong>Categorias dos Produtos</strong></span>
                                </a>
                            </li>
                            <li id="subTipoA">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicionais">
                                    <span class="d-inline-block"><strong>Categorias dos Adicionais</strong></span>
                                </a>
                            </li>
                            </ul>
                        </div>
                    </li>
                    <li id="menuUsuarios">
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuUsuarios" aria-expanded="true"
                            aria-controls="collapseMenuUsuarios" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="iconsminds-conference iconeMenu"></span> <span class="d-inline-block">Usuarios</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseMenuUsuarios" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                            {% if nivelUsuario == 0 %}
                            {% if planoAtivo > 2 %}
                            <li id="subAt">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/atendentes" >
                                    <span class="d-inline-block"><strong>Atendentes</strong></span>
                                </a>
                            </li>
                            {% endif %}
                            {% endif %}

                            <li id="subCli">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/clientes">
                                    <span class="d-inline-block"><strong>Clientes</strong></span>
                                </a>
                            </li>
                            {% if nivelUsuario == 0 %}
                            <li id="subUn">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/usuario/novo" >
                                    <span class="d-inline-block"><strong>Novo Usuário</strong></span>
                                </a>
                            </li>
                            {% endif %}
                            </ul>
                        </div>
                    </li>
                    {% if nivelUsuario == 0 %}
                    <li id="menuConfiguracoes">
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuConfiguracoes" aria-expanded="true"
                            aria-controls="collapseMenuConfiguracoes" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="iconsminds-gear iconeMenu"></span> <span class="d-inline-block">Configurações</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseMenuConfiguracoes" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                            <li id="subMp">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/planos" >
                                    <span class="d-inline-block"><strong>Planos e Valores</strong></span>
                                </a>
                            </li>
                            <li id="subEmp">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/e" >
                                    <span class="d-inline-block"><strong>Sobre Empresa</strong></span>
                                </a>
                            </li>
                            <li id="subDeli">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/delivery/e">
                                    <span class="d-inline-block"><strong>Dados Delivery</strong></span>
                                </a>
                            </li>
                            <li id="subDeliTip">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/delivery">
                                    <span class="d-inline-block"><strong>Tipo de Delivery</strong></span>
                                </a>
                            </li>
                            <li  id="subFp">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento">
                                    <span class="d-inline-block"><strong>Método de Pagamento</strong></span>
                                </a>
                            </li>
                            {% if planoAtivo > 1 %}
                            <li  id="subCu">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/cupons">
                                    <span class="d-inline-block"><strong>Cupom Desconto</strong></span>
                                </a>
                            </li>
                            {% endif %}
                            </ul>
                        </div>
                    </li>
                    {% if planoAtivo > 3 %}

                    <li id="menuIntegracao">
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuIntegracao" aria-expanded="true"
                            aria-controls="collapseMenuIntegracao" class="primaryMenu rotate-arrow-icon collapsed">
                            <span class="simple-icon-link iconeMenu"></span> <span class="d-inline-block">Integrações</span>
                            <i class="simple-icon-arrow-down iconAcao"></i>
                        </a>
                        <div id="collapseMenuIntegracao" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                            <ul class="list-unstyled inner-level-menu">
                            <li id="subIfood">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/ifood" >
                                    <span class="d-inline-block"><strong>iFood</strong></span>
                                </a>
                            </li>
                            <li id="subUberEats">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/ubereats" >
                                    <span class="d-inline-block"><strong>UberEats</strong></span>
                                </a>
                            </li>
                            <li id="subClickEntregas">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/click-entregas">
                                    <span class="d-inline-block"><strong>Click Entregas</strong></span>
                                </a>
                            </li>
                            </ul>
                        </div>
                    </li>
                    <li id="menuChat">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/mensagens" class="primaryMenu">
                            <span class="simple-icon-earphones-alt iconeMenu"></span>
                            <span class="d-inline-block">Mensagens</span>
                        </a>
                    </li>
                    <li id="menuAvaliacao">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/avaliacao" class="primaryMenu">
                            <span class="simple-icon-star iconeMenu"></span>
                            <span class="d-inline-block">Avaliação</span>
                        </a>
                    </li>
                    <li id="menuDocs">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/docs" class="primaryMenu">
                            <span class="iconsminds-library iconeMenu"></span>
                            <span class="d-inline-block">Ajuda</span>
                        </a>
                    </li>
                    {% endif %}
                    {% endif %}
                </ul>

            </div>
        </div>
    </div>