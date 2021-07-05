{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

{% set total5 = 0 %}
{% set total4 = 0 %}
{% set total3 = 0 %}
{% set total2 = 0 %}
{% set total1 = 0 %}

{% set total5Moto = 0 %}
{% set total4Moto = 0 %}
{% set total3Moto = 0 %}
{% set total2Moto = 0 %}
{% set total1Moto = 0 %}


{% for r in ratingAll %}
    {% if noventa <= r.updated_at %}
        {% if r.avaliacao_pedido == 1 %}
            {% set total1 = total1 + 1 %}
        {% endif %}

        {% if r.avaliacao_pedido == 2 %}
            {% set total2 = total2 + 1 %}
        {% endif %}
        {% if r.avaliacao_pedido == 3 %}
            {% set total3 = total3 + 1 %}
        {% endif %}
        {% if r.avaliacao_pedido == 4 %}
            {% set total4 = total4 + 1 %}
        {% endif %}
        {% if r.avaliacao_pedido == 5 %}
            {% set total5 = total5 + 1 %}
        {% endif %}

        {% if r.avaliacao_motoboy == 1 %}
            {% set total1Moto = total1Moto + 1 %}
        {% endif %}

        {% if r.avaliacao_motoboy == 2 %}
            {% set total2Moto = total2Moto + 1 %}
        {% endif %}
        {% if r.avaliacao_motoboy == 3 %}
            {% set total3Moto = total3Moto + 1 %}
        {% endif %}
        {% if r.avaliacao_motoboy == 4 %}
            {% set total4Moto = total4Moto + 1 %}
        {% endif %}

        {% if r.avaliacao_motoboy == 5 %}
            {% set total5Moto = total5Moto + 1 %}
        {% endif %}
    
    {% endif %}
    {% endfor %}
<div class="container-fluid">
    <div class="col-12">
        <h1>Avaliações</h1>
        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item active" aria-current="page">tempo real</li>
            </ol>
        </nav>
        <div class="separator mb-5"></div>

    </div>

    <div class="reviews-performance">
        <div class="col-md-12 reviews-performance-section-header__title">
            <div>{{rating}} avaliações nos últimos 90 dias</div>
        </div>
        <div class="col-md-12 reviews-performance__section-sub reviews-performance__section-sub--date-section-sub">
            <div class="reviews-performance-sub-section-header">
                <div class="reviews-performance-sub-section-header__title col-md-12">{{ noventa|date('d/m/Y') }} a {{ hoje|date('d/m/Y') }}</div>
            </div>
        </div>
        <div class="reviews-performance__section-body">
            <div class="reviews-performance-detail-body__section-body">

                <div class="col-md-12 col-lg-6 col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="reviews-performance-detail-section">
                                <div class="reviews-performance-detail-section__title">Itens</div>
                                <div class="reviews-performance-detail-section__subtitle">Nota média</div>
                                <div
                                    class="reviews-performance-detail-food-section reviews-performance-detail-body__section">
                                    <div class="reviews-performance-detail-food-section__header">
                                        <div class="reviews-performance-detail-food-section__value"><span
                                                class="reviews-performance-detail-food-section__title">{{votacaoPedidos|number_format(2, ',', '.')}}</span>
                                            <div class="reviews-performance-detail-food-section__rating">
                                                <div class="ratings rating--empty">
                                                    <div class="rating__icons"><i aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoPedidos >= 1 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoPedidos >= 2 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoPedidos >= 3 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoPedidos >= 4 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoPedidos >= 5 %} {% else %}-o{% endif %}"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="horizontal-divider horizontal-divider--rounded reviews-performance-detail-food-section__divider">
                                        </div>
                                    </div>
                                    <div class="reviews-performance-detail-food-section__chart">
                                        <div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star" alt="Estrela"><span
                                                        class="reviews-performance-bar-chart__subtitle">5</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total5}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star" alt="Estrela"><span
                                                        class="reviews-performance-bar-chart__subtitle">4</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total4}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">3</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total3}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">2</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total2}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">1</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total1}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="reviews-performance-detail-section">
                                <div class="reviews-performance-detail-section__title">Entrega</div>
                                <div class="reviews-performance-detail-section__subtitle">Satisfação com a entrega</div>
                                <div
                                    class="reviews-performance-detail-food-section reviews-performance-detail-body__section">
                                    <div class="reviews-performance-detail-food-section__header">
                                        <div class="reviews-performance-detail-food-section__value"><span
                                                class="reviews-performance-detail-food-section__title">{{ votacaoEntrega|number_format(2, ',', '.') }}</span>
                                            <div class="reviews-performance-detail-food-section__rating">
                                                <div class="ratings rating--empty">
                                                    <div class="rating__icons"><i aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoEntrega >= 1 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoEntrega >= 2 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoEntrega >= 3 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoEntrega >= 4 %} {% else %}-o{% endif %}"></i><i
                                                            aria-hidden="true"
                                                            class="icon rating__icon fa fa-star{% if votacaoEntrega >= 5 %} {% else %}-o{% endif %}"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="horizontal-divider horizontal-divider--rounded reviews-performance-detail-food-section__divider">
                                        </div>
                                    </div>
                                    <div class="reviews-performance-detail-food-section__chart">
                                        <div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star" alt="Estrela"><span
                                                        class="reviews-performance-bar-chart__subtitle">5</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total5Moto}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star" alt="Estrela"><span
                                                        class="reviews-performance-bar-chart__subtitle">4</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total4Moto}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">3</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total3Moto}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">2</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total2Moto}}</span>
                                                </div>
                                            </div>
                                            <div
                                                class="reviews-performance-bar-chart reviews-performance-bar-chart--pointer">
                                                <div
                                                    class="reviews-performance-bar-chart__container reviews-performance-bar-chart__container--hover">
                                                    <img src="https://portal.ifood.com.br/partner-portal-reviews-web-front/static/media/star.606b3569.svg"
                                                        class="reviews-performance-bar-chart__star reviews-performance-bar-chart__star--rotate"
                                                        alt="Não gostei"><span
                                                        class="reviews-performance-bar-chart__subtitle">1</span>
                                                    <div class="review-bar reviews-performance-bar-chart__bar reviews-performance-bar-chart__bar--danger"
                                                        style="width: 0.5%;"></div><span
                                                        class="reviews-performance-bar-chart__subtitle">{{total1Moto}}</span>
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

    </div>


</div>
{% endblock %}