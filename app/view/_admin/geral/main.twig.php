{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<div class="container-fluid">
    <div class="dashboard-wrapper">
        <div class="row">
            <div class="col-12">
                <h1><span>Sistema de Gestão de Delivery</span></h1>
                <div class="separator mb-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-4 card">
                    <div class="card-body">
                        <div class="jumbotron">
                            <h1 class="display-4">Bem-vindo!</h1>
                            <p class="lead">Obrigado por escolher a Automatiza App, aqui você encontra tudo sobre o sistema.</p>
                            <hr class="my-4">
                            <p class="mb-5"><b>Produto:</b> Sistema de Gestão de Delivery<br><b>Autor:</b>
                                Automatiza App<br><b>Versão:</b> 2.0.1<br></p>
                            <p>Esta documentação é para ajudá-lo em cada etapa de personalização e para começar. Por favor, leia a documentação cuidadosamente para entender como p sistema funciona.</p>
                            <p></p>



                            <p class="lead mt-5 pt-5">Funções Básicas.</p>

                            <div id="accordion" class="mt-2">

                                <div class="border">
                                    <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#delivery" aria-expanded="false" aria-controls="delivery">
                                        1 - Configurando seu Delivery
                                    </button>
                                    <div id="delivery" class="collapse show" data-parent="#accordion">
                                        <div class="p-4">
                                            Neste Video te ensinamos a como configurar as informações de entrega de seu delivery
                                        </div>
                                    </div>
                                </div>

                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#categoria"
                                        aria-expanded="true" aria-controls="categoria">
                                        2 - Como Criar uma Categoria
                                    </button>

                                    <div id="categoria" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                            Neste Video te ensinamos a como criar uma categoria para seus produtos.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#produtos" aria-expanded="false"
                                        aria-controls="produtos">
                                        3 -  Adicionar um novo Produto
                                    </button>
                                    <div id="produtos" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                            Neste Video te ensinamos a como criar um produto e deixar ele disponível para seus clientes.
                                        </div>
                                    </div>
                                </div>

                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#sabor" aria-expanded="false"
                                        aria-controls="sabor">
                                        4 -  Adicionar um novo Sabor
                                    </button>
                                    <div id="sabor" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                            Neste Video te ensinamos a como criar um sabor e como atribuir a seus produtos.
                                        </div>
                                    </div>
                                </div>

                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#adicionais" aria-expanded="false"
                                        aria-controls="adicionais">
                                        5 -  Adicionar um novo Sabor
                                    </button>
                                    <div id="adicionais" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                            Neste Video te ensinamos a como criar Itens adicionais para seus produtos e como atrelar em seus produtos.
                                        </div>
                                    </div>
                                </div>


                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#adicionais" aria-expanded="false"
                                        aria-controls="adicionais">
                                        6 -  Iniciando o Atendimento
                                    </button>
                                    <div id="adicionais" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                           Após configurado seu cardápio te mostraremos neste video como iniciar seu Atendimento no delivery.
                                        </div>
                                    </div>
                                </div>


                                <div class="border">
                                    <button class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#adicionais" aria-expanded="false"
                                        aria-controls="adicionais">
                                        7 -  Recebendo Pedidos
                                    </button>
                                    <div id="adicionais" class="collapse" data-parent="#accordion">
                                        <div class="p-4">
                                           Neste video falamos como funciona o recebimento de cada pedido e como usar as funções do sistema.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
{% endblock %}
