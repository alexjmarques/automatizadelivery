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
                {% if planoAtivo > 2 %}
                <li id="menuCaixa">
                    <a href="#" data-toggle="collapse" data-target="#collapseCaixaTypes" aria-expanded="true" aria-controls="collapseCaixaTypes" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="iconsminds-digital-drawing iconeMenu"></span> <span class="d-inline-block"> Relatórios</span>
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
                                <a href="{{BASE}}{{empresa.link_site}}/admin/caixa/relatorio">
                                    <span class="d-inline-block">Relatório de Vendas</span>
                                </a>
                            </li>
                            <li id="caiCli">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/clientes/relatorio">
                                    <span class="d-inline-block">Relatórios Clientes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {% else %}
                <li id="menuCaixa" class="indisponivel">
                    <a href="#">
                        <span class="iconsminds-digital-drawing iconeMenu"></span> <span class="d-inline-block"> Relatórios</span>
                    </a>
                </li>
                {% endif %}
                {% endif %}

                <li id="menuPedido">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuTypes" aria-expanded="true" aria-controls="collapseMenuTypes" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="iconsminds-shop-4 iconeMenu"></span> <span class="d-inline-block"> Pedidos Delivery</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuTypes" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subPn">
                                {% if planoAtivo == 0 %}
                                <a href="#">
                                    {% else %}
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/pedido/novo">
                                        {% endif %}
                                        <span class="d-inline-block"><strong>Novo Pedido</strong></span>
                                    </a>
                            </li>
                            <li id="subPd">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos">
                                    <span class="d-inline-block"><strong>Pedidos de Hoje</strong></span>
                                </a>
                            </li>
                            {% if nivelUsuario == 0 %}
                            {% if planoAtivo > 1 %}
                            <li id="subPf">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos-finalizados">
                                    <span class="d-inline-block"><strong>Pedidos Finalizados</strong></span>
                                </a>
                            </li>
                            {% else %}
                            <li id="subPf" class="indisponivel">
                                <a href="#">
                                    <span class="d-inline-block">Todos Pedidos </span>
                                </a>
                            </li>
                            {% endif %}
                            {% endif %}
                        </ul>
                    </div>
                </li>
                {% if nivelUsuario == 0 %}
                {% if planoAtivo > 2 %}
                <li id="menuMotoboys">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuMotoboys" aria-expanded="true" aria-controls="collapseMenuMotoboys" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="simple-icon-plane iconeMenu"></span> <span class="d-inline-block">Motoboys</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuMotoboys" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subMt">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/motoboys">
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
                {% else %}
                <li id="menuMotoboys" class="indisponivel">
                    <a href="#">
                        <span class="simple-icon-plane iconeMenu"></span> <span class="d-inline-block">Motoboys </span>
                    </a>
                </li>
                {% endif %}
                
                {% endif %}
                <li id="menuProdutos">
                    <a href="#" data-toggle="collapse" data-target="#collapseProdutos" aria-expanded="true" aria-controls="collapseProdutos" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="iconsminds-cash-register-2 iconeMenu"></span> <span class="d-inline-block">Cardápios</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseProdutos" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subProd">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/cardapio">
                                    <span class="d-inline-block"><strong>Categoria e Produtos</strong></span>
                                </a>
                            </li>
                            {% if empresa.id_categoria == 6 %}
                            <li id="subTam">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tamanhos">
                                    <span class="d-inline-block"><strong>Tamanho de Pizza</strong></span>
                                </a>
                            </li>
                            <li id="subMass">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/massas">
                                    <span class="d-inline-block"><strong>Borda de Pizza</strong></span>
                                </a>
                            </li>
                            {% endif %}
                            
                            <li id="subSabores">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-sabores">
                                    <span class="d-inline-block"><strong>Sabores</strong></span>
                                </a>
                            </li>
                            <li id="subProdA">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-adicionais">
                                    <span class="d-inline-block"><strong>Adicionais</strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li id="menuUsuarios">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuUsuarios" aria-expanded="true" aria-controls="collapseMenuUsuarios" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="iconsminds-conference iconeMenu"></span> <span class="d-inline-block">Usuarios</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuUsuarios" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            {% if nivelUsuario == 0 %}
                            {% if planoAtivo > 2 %}
                            <li id="subAt">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/atendentes">
                                    <span class="d-inline-block"><strong>Atendentes</strong></span>
                                </a>
                            </li>
                            {% else %}
                            <li id="subAt" class="indisponivel">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/atendentes">
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
                            {% if planoAtivo > 2 %}
                            <li id="subUn">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/administradores">
                                    <span class="d-inline-block"><strong>Administradores</strong></span>
                                </a>
                            </li>
                            {% else %}
                            <li id="subUn" class="indisponivel">
                                <a href="#">
                                    <span class="d-inline-block"><strong>Administradores</strong></span>
                                </a>
                            </li>

                            {% endif %}
                            {% endif %}
                            <li id="subPer">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/meu-perfil">
                                    <span class="d-inline-block"><strong>Meu Perfil</strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {% if nivelUsuario == 0 %}
                <li id="menuConfiguracoes">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuConfiguracoes" aria-expanded="true" aria-controls="collapseMenuConfiguracoes" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="iconsminds-gear iconeMenu"></span> <span class="d-inline-block">Configurações</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuConfiguracoes" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subEmp">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/e">
                                    <span class="d-inline-block"><strong>Empresa</strong></span>
                                </a>
                            </li>
                            
                            <li id="subDeli">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/delivery/e">
                                    <span class="d-inline-block"><strong>Delivery</strong></span>
                                </a>
                            </li>
                            
                            <li id="subHor">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento">
                                    <span class="d-inline-block"><strong>Horários</strong></span>
                                </a>
                            </li>

                            {% if planoAtivo > 2 %}
                            <li id="subCu">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/cupons">
                                    <span class="d-inline-block"><strong>Cupom Desconto</strong></span>
                                </a>
                            </li>
                            {% else %}
                            <li id="subCu" class="indisponivel">
                                <a href="#">
                                    <span class="d-inline-block"><strong>Cupom Desconto</strong> </span>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </div>
                </li>

                <li id="menuAuxiliares">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuAuxiliares" aria-expanded="true" aria-controls="collapseMenuAuxiliares" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="simple-icon-layers iconeMenu"></span> <span class="d-inline-block">Auxiliares</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuAuxiliares" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subStatus">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/status">
                                    <span class="d-inline-block"><strong>Status</strong></span>
                                </a>
                            </li>
                            <li id="subDeliTip">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/delivery">
                                    <span class="d-inline-block"><strong>Tipo de Delivery</strong></span>
                                </a>
                            </li>
                            <li id="subFp">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento">
                                    <span class="d-inline-block"><strong>Método de Pagamento</strong></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {% if planoAtivo > 4 %}

                <li id="menuIntegracao">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenuIntegracao" aria-expanded="true" aria-controls="collapseMenuIntegracao" class="primaryMenu rotate-arrow-icon collapsed">
                        <span class="simple-icon-link iconeMenu"></span> <span class="d-inline-block">Integrações</span>
                        <i class="simple-icon-arrow-down iconAcao"></i>
                    </a>
                    <div id="collapseMenuIntegracao" class="collapse rounded-left cianColor" data-parent="#menuTypes">
                        <span class="triangulo-top"></span>
                        <ul class="list-unstyled inner-level-menu">
                            <li id="subIfood">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/ifood">
                                    <span class="d-inline-block"><strong>iFood</strong></span>
                                </a>
                            </li>
                            <li id="subUberEats">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/ubereats">
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
                {% else %}
                <li id="menuIntegracao" class="indisponivel">
                <a href="#">
                        <span class="simple-icon-link iconeMenu"></span> <span class="d-inline-block">Integrações </span>
                    </a>
                </li>
                {% endif %}

                {% if planoAtivo > 3 %}
                <li id="menuAvaliacao">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/avaliacao" class="primaryMenu">
                        <span class="simple-icon-star iconeMenu"></span>
                        <span class="d-inline-block">Avaliação</span>
                    </a>
                </li>
                {% else %}
                <li id="menuAvaliacao" class="indisponivel">
                    <a href="#">
                        <span class="simple-icon-star iconeMenu"></span>
                        <span class="d-inline-block">Avaliação </span>
                    </a>
                </li>
                {% endif %}
                {% endif %}
                {% if planoAtivo > 2 %}
                <li id="menuChat">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/suporte" class="primaryMenu">
                        <span class="simple-icon-earphones-alt iconeMenu"></span>
                        <span class="d-inline-block">Suporte</span>
                    </a>
                </li>
                {% endif %}
                <li id="menuDocs">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/docs" class="primaryMenu">
                        <span class="iconsminds-library iconeMenu"></span>
                        <span class="d-inline-block">Ajuda</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>