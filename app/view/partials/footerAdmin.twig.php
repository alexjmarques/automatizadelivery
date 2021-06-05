<footer class="page-footer">
    <div class="footer-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p class="mb-0 text-muted">Automatiza.App 2021</p>
                </div>
            </div>
        </div>
    </div>
</footer>




<div class="modal fade" id="caixa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body text-center">
                {% if caixa is not null %}
                <div class="cian-rouded p-2">
                    <div class="w4rAnimated_checkmark pb-3">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" class="successSup">
                            <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                        </svg>
                    </div>
                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-check text-success"></i> Loja online Aberta</p>
                        {% if statusiFood.idLoja is not null %}
                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-check text-success"></i> Loja Conectada à rede do iFood</p>
                        {% endif %}
                        {% if statusUber.idLoja is not null %}
                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-check text-success"></i> Loja Conectada à rede do UberEats</p>
                        {% endif %}
                </div>
                <p class="mb-3 text-center size16">Para finalizar o atendimento, clique no botão abaixo</p>
                <div class="mt-3">
                    <form method="post" id="formAtendimento" action="{{BASE}}{{empresa.link_site}}/admin/finalizar-atendimento" novalidate>
                        <input type="hidden" value="{{caixa.id}}" name="id_caixa" id="id_caixa">
                        <button class="mt-3 btn btn-lg btn-block btn-continuar btn-finalizar">Finalizar
                            Atendimento</button>
                    </form>
                    {% else %}
                    
                    <div class="w4rAnimated_checkmark pb-3">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" class="errorSup">
                            <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2" />
                        </svg>
                    </div>

                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-close text-danger"></i> Loja online desconectada</p>
                        {% if statusiFood.idLoja is not null %}
                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-close text-danger"></i> Loja desconectada da rede do iFood</p>
                        {% endif %}
                        {% if statusUber.idLoja is not null %}
                    <p class="mb-3 text-center size16 bold"><i class="simple-icon-close text-danger"></i> Loja desconectada da rede do UberEats</p>
                        {% endif %}
                        {% if planoAtivo is null %}
                    <p>Vimos que você ainda não contratou nenhum plano! Para utilizar nossos serviços e necessário ter um plano ativo! </p>
                    <a href="{{BASE}}{{empresa.link_site}}/admin/planos" class="btn btn-primary">Contratar Agora</a>
                    {% else %}
                    Para iniciar o atendimento e liberar para seus clientes fazerem pedidos, clique no botão abaixo

                    <div class="mt-3">
                        <form method="post" id="formAtendimento" action="{{BASE}}{{empresa.link_site}}/admin/iniciar-atendimento" novalidate>
                            <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
                            <button class="mt-3 btn btn-lg btn-block btn-continuar">Iniciar Atendimento</button>
                        </form>
                        <div class="mensagem"></div>
                        {% endif %}
                    </div>
                    {% endif %}
                </div>

            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="alerta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="w4rAnimated_checkmark">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" class="successSup" style="display: none">
                            <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                        </svg>

                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" class="errorSup" style="display: none">
                            <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3" />
                            <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2" />
                        </svg>
                    </div>

                    <h3 class="swal2-title text-center" id="mensagem"></h3>
                        <div class="swal2-actions">
                            <button type="button" class="buttonAlert" data-dismiss="modal" aria-label="Close">OK</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="alertaIfood" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-left">Autorizar Aplicativo</h2>
                            <p class="text-left">
                                Siga os Passos para autorizar o Aplicativo e receber seus pedidos do iFood direto em nossa plataforma.
                                </br></br>
                                1º - <strong id="codeLink"></strong> para acessar sua conta do iFood e validar ou se preferir acesse sua conta <strong>iFood Menu > Aplicativo</strong> e quando solicitar o codigo informe conforme abaixo! <br />
                                </br>
                                2º - Após autorizar copie o código gerado pelo iFood e cole no campo abaixo e clique em <strong>Validar</strong>
                            </p>
                            <div class="bWqRVn text-center mb-2" id="codeOpen"></div>
                            <form method="post" action="{{BASE}}{{empresa.link_site}}/admin/conectar/ifood/final" enctype="multipart/form-data" class="full-width">
                                <div class="dados-usuario full-width">
                                    <div class="col-md-12 pr-0 pl-0">
                                        <div class="form-group">
                                            <label class="text-dark userCode" for="userCode">Código de autorização do
                                                iFood <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="userCode" name="userCode" value="" required>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
                                <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtnAutorizar"><span>Validar</span></button>
                            </form>
                </div>
            </div>
        </div>
    </div>