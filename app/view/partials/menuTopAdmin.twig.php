{% if planoAtivo is null %}
    <a href="#" class="atendimento plano alert alert-danger"><p>Vimos que você ainda não contratou nenhum plano! Para utilizar nossos serviços e necessário ter um plano ativo! <span class="botao">Ativar um Plano?</span></p></a>
{% endif %}

<nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>

        
    </div>


    <a class="navbar-logo" href="#">
        <span class="logo d-none d-xs-block"></span>
        <span class="logo-mobile d-block d-xs-none"></span>
    </a>

    <div class="navbar-right">
        <div class="header-icons d-inline-block align-middle">
            <div class="d-none d-md-inline-block align-text-bottom mr-3">
            {% if planoAtivo is not null %}
            {% if caixa == 1 %}
                <button type="button" id="atendimentoOn" class="botao atendimento on" data-toggle="modal" data-target="#caixa"><p><i class="simple-icon-check text-success"></i> <span class="botao">LOJA ABERTA</span></p></button>
                {% else %}
                <button type="button" id="atendimentoOff" class="atendimento" data-toggle="modal" data-target="#caixa"><p><i class="simple-icon-close"></i> <span class="botao">Loja Fechada</span></p></button>
            {% endif %}
            {% endif %}

            </div>

            

            <!-- <div class="position-relative d-inline-block">
                <button class="header-icon btn btn-empty" type="button" id="notificationButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="simple-icon-bell"></i>
                    <span class="count">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute" id="notificationDropdown">
                    <div class="scroll">
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="img/profiles/l-2.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">Joisse Kaycee just sent a new comment!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="img/notifications/1.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">1 item is out of stock!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="img/notifications/2.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">New order received! It is total $147,20.</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 ">
                            <a href="#">
                                <img src="img/notifications/3.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">3 items just added to wish list by a user!
                                    </p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                <i class="simple-icon-size-fullscreen"></i>
                <i class="simple-icon-size-actual"></i>
            </button>
        </div>

        <div class="user d-inline-block">
            
<button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="name">{{usuarioLogado.nome}}</span>
                <span>
                    <i class="iconsminds-conference"></i>

                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/admin/meu-perfil">Minha conta</a>
                <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/admin/conf/e">Configuração da Empresa</a>
                    <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/admin/pedidos">Pedidos Delivery</a>
                    {% if planoAtivo > 2 %}
                    <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/suporte">Suporte</a>
                    {% endif %}
                    <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/docs">Ajuda</a>
                    <a class="dropdown-item" href="{{BASE}}{{empresa.link_site}}/admin/sair">Sair</a>
            </div>
        </div>
    </div>
    
</nav>


