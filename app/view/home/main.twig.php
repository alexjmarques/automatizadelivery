{% extends 'partials/body.twig.php'  %}
{% block title %}{{empresa.nome_fantasia}} - Automatiza.App{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% if detect.isMobile() %}
{% include 'partials/headerPrincipal.twig.php' %}
<div id="listarUltimaVenda"></div>
<div class="osahan-home-page">
    <div class="bg-light">
        {% include 'home/mobile/promocao.twig.php' %}
        {% include 'home/mobile/categoria.twig.php' %}
        {% include 'home/mobile/maisVendidos.twig.php' %}
    </div>
</div>
{% if delivery.status == 0 %}
<div class="StatusRest ">ESTAMOS FECHADOS NO MOMENTO</div>
{% endif %}
{% if isLogin is not empty %}
{% if isLogin != 'undefined' %}
{% if isLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endif %}
{% else %}

{% include 'partials/desktop/menuTopWhiteParcial.twig.php' %}

<section class="restaurant-detailed-banner">
         <div class="text-center">
         {% if empresa.capa is null or empresa.capa == "" %}
            <img src="/img/bg.png" class="img-fluid cover">
        {% else %}
            <img src="/uploads/{{empresa.capa}}" class="img-fluid cover">
        {% endif %}
         </div>
         <div class="restaurant-detailed-header">
            <div class="container">
               <div class="row d-flex align-items-end">
                  <div class="col-md-8">
                     <div class="restaurant-detailed-header-left">
                     {% if empresa.logo is null %}
                        <img src="/uploads/logo_modelo.png" class="img-fluid mr-3 float-left">
                        {% else %}
                        <img src="/uploads/{{empresa.logo}}" class="img-fluid mr-3 float-left">
                        {% endif %}
                        <h2 class="text-white">{{empresa.nome_fantasia}}</h2>
                        <p class="text-white mb-1"><i class="icofont-location-pin"></i> {{ endereco.rua }} {{ endereco.numero }}, {% if endereco.complemento != "" %} {{ endereco.complemento }} , {% endif %}  {{ endereco.bairro }} - {{ endereco.cidade }}/{{ endereco.estado }}
                        
                        {% if delivery.status == 1 %}
                        <span class="badge badge-success"><i class="mdi mdi-clock-outline"></i> Aberto</span>
                        {% else %}
                        <span class="badge badge-danger"><i class="mdi mdi-clock-outline"></i> Fechado </span>
                        {% endif %}
                        </p>
                        {% if empresa.sobre != "" %}
                        <p class="text-white mb-0"><i class="icofont-food-cart"></i> {{empresa.sobre}}</p>
                        {% endif %}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="restaurant-detailed-header-right text-right">
                        <button class="btn btn-success" type="button"><i class="icofont-clock-time"></i> {{delivery.previsao_minutos}}</button>
                        <!-- <h6 class="text-white mb-0 restaurant-detailed-ratings"><span class="generator-bg rounded text-white"><i class="icofont-star"></i> 3.1</span> 23 Ratings  <i class="ml-3 icofont-speech-comments"></i> 91 reviews</h6> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         </div> 
      </section>
      <section class="offer-dedicated-nav bg-white border-top-0 shadow-sm">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <!-- <span class="restaurant-detailed-action-btn float-right">
                  <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-heart text-danger"></i> Mark as Favourite</button>
                  <button class="btn btn-light btn-sm border-light-btn" type="button"><i class="icofont-cauli-flower text-success"></i>  Pure Veg</button>
                  <button class="btn btn-outline-danger btn-sm" type="button"><i class="icofont-sale-discount"></i>  OFFERS</button>
                  </span> -->
                  <ul class="nav" id="pills-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="pills-order-online-tab" data-toggle="pill" href="#pills-order-online" role="tab" aria-controls="pills-order-online" aria-selected="true">Produtos</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-restaurant-info-tab" data-toggle="pill" href="#pills-restaurant-info" role="tab" aria-controls="pills-restaurant-info" aria-selected="false">Informações</a>
                     </li>
                     <!-- <li class="nav-item">
                        <a class="nav-link" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">Book A Table</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="pills-reviews-tab" data-toggle="pill" href="#pills-reviews" role="tab" aria-controls="pills-reviews" aria-selected="false">Ratings & Reviews</a>
                     </li> -->
                  </ul>
               </div>
            </div>
         </div>
      </section>
      <section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="offer-dedicated-body-left">
                     <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                           
                           <div class="row">
                              <h5 class="mb-4 mt-3 col-md-12">Os mais vendidos</h5>
                              
                              {% include 'home/desktop/maisVendidos.twig.php' %}
                              
                           </div>
                           
                           <div class="row">
                              {% include 'home/desktop/categoria.twig.php' %}
                           </div>
                        </div>
                        
                        <div class="tab-pane fade" id="pills-restaurant-info" role="tabpanel" aria-labelledby="pills-restaurant-info-tab">
                           <div id="restaurant-info" class="bg-white rounded shadow-sm p-4 mb-4">
                              <div class="address-map float-right ml-5">
                                 <div class="mapouter">
                                    <div class="gmap_canvas"><iframe width="300" height="370" id="gmap_canvas" src="https://maps.google.com/maps?q={{ endereco.rua }}%20{{ endereco.numero }}%20{{ endereco.cidade }}%20{{ endereco.estado }}&t=&z=9&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                                 </div>
                              </div>
                              <h5 class="mb-4">Informações</h5>
                              <p class="mb-3">{{ endereco.rua }} {{ endereco.numero }}, {% if endereco.complemento != "" %} {{ endereco.complemento }} , {% endif %}  {{ endereco.bairro }} - {{ endereco.cidade }}/{{ endereco.estado }}
                              </p>
                              <p class="mb-2 text-black"><i class="icofont-phone-circle text-primary mr-2"></i> ({{ empresa.telefone[:2] }}) {{ empresa.telefone|slice(2, 5) }}-{{ empresa.telefone|slice(7, 9) }}</p>
                              <hr class="clearfix">
                              {% for at in atendimento %}
                              {% for d in dias %}
                              {% if d.id == at.code_dia %}
                              <p class="mb-2 text-black"><i class="icofont-clock-time text-primary mr-2"></i> {{ d.nome }}  das {{at.abertura}} às {{at.fechamento}}</p>
                              {% endif %}
                              {% endfor %}
                              {% endfor %}

                              <!-- <hr class="clearfix">
                              <h5 class="mt-4 mb-4">More Info</h5>
                              <p class="mb-3">Dal Makhani, Panneer Butter Masala, Kadhai Paneer, Raita, Veg Thali, Laccha Paratha, Butter Naan</p>
                              <div class="border-btn-main mb-4">
                                 <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                 <a class="border-btn text-danger mr-2" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                 <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                                 <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Indoor Seating</a>
                                 <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Breakfast</a>
                                 <a class="border-btn text-danger mr-2" href="#"><i class="icofont-close-circled"></i> No Alcohol Available</a>
                                 <a class="border-btn text-success mr-2" href="#"><i class="icofont-check-circled"></i> Vegetarian Only</a>
                              </div> -->
                           </div>
                        </div>
                        <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">
                           <div id="book-a-table" class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                              <h5 class="mb-4">Book A Table</h5>
                              <form>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Full Name</label>
                                          <input class="form-control" type="text" placeholder="Enter Full Name">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Email Address</label>
                                          <input class="form-control" type="text" placeholder="Enter Email address">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Mobile number</label>
                                          <input class="form-control" type="text" placeholder="Enter Mobile number">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Date And Time</label>
                                          <input class="form-control" type="text" placeholder="Enter Date And Time">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group text-right">
                                    <button class="btn btn-primary" type="button"> Submit </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                           <div id="ratings-and-reviews" class="bg-white rounded shadow-sm p-4 mb-4 clearfix restaurant-detailed-star-rating">
                              <span class="star-rating float-right">
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x active"></i></a>
                              <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                              </span>
                              <h5 class="mb-0 pt-1">Rate this Place</h5>
                           </div>
                           <div class="bg-white rounded shadow-sm p-4 mb-4 clearfix graph-star-rating">
                              <h5 class="mb-0 mb-4">Ratings and Reviews</h5>
                              <div class="graph-star-rating-header">
                                 <div class="star-rating">
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating active"></i></a>
                                    <a href="#"><i class="icofont-ui-rating"></i></a>  <b class="text-black ml-2">334</b>
                                 </div>
                                 <p class="text-black mb-4 mt-2">Rated 3.5 out of 5</p>
                              </div>
                              <div class="graph-star-rating-body">
                                 <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                       5 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 56%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="rating-list-right text-black">56%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                       4 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 23%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="rating-list-right text-black">23%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                       3 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 11%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="rating-list-right text-black">11%</div>
                                 </div>
                                 <div class="rating-list">
                                    <div class="rating-list-left text-black">
                                       2 Star
                                    </div>
                                    <div class="rating-list-center">
                                       <div class="progress">
                                          <div style="width: 2%" aria-valuemax="5" aria-valuemin="0" aria-valuenow="5" role="progressbar" class="progress-bar bg-primary">
                                             <span class="sr-only">80% Complete (danger)</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="rating-list-right text-black">02%</div>
                                 </div>
                              </div>
                              <div class="graph-star-rating-footer text-center mt-3 mb-3">
                                 <button type="button" class="btn btn-outline-primary btn-sm">Rate and Review</button>
                              </div>
                           </div>
                           <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
                              <a href="#" class="btn btn-outline-primary btn-sm float-right">Top Rated</a>
                              <h5 class="mb-1">All Ratings and Reviews</h5>
                              <div class="reviews-members pt-4 pb-4">
                                 <div class="media">
                                    <a href="#"><img alt="Generic placeholder image" src="img/user/1.png" class="mr-3 rounded-pill"></a>
                                    <div class="media-body">
                                       <div class="reviews-members-header">
                                          <span class="star-rating float-right">
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating"></i></a>
                                          </span>
                                          <h6 class="mb-1"><a class="text-black" href="#">Singh Osahan</a></h6>
                                          <p class="text-gray">Tue, 20 Mar 2020</p>
                                       </div>
                                       <div class="reviews-members-body">
                                          <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections </p>
                                       </div>
                                       <div class="reviews-members-footer">
                                          <a class="total-like" href="#"><i class="icofont-thumbs-up"></i> 856M</a> <a class="total-like" href="#"><i class="icofont-thumbs-down"></i> 158K</a> 
                                          <span class="total-like-user-main ml-2" dir="rtl">
                                          <a data-toggle="tooltip" data-placement="top" title="Gurdeep Osahan" href="#"><img alt="Generic placeholder image" src="img/user/5.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Gurdeep Singh" href="#"><img alt="Generic placeholder image" src="img/user/2.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Askbootstrap" href="#"><img alt="Generic placeholder image" src="img/user/3.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Osahan" href="#"><img alt="Generic placeholder image" src="img/user/4.png" class="total-like-user rounded-pill"></a>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <div class="reviews-members pt-4 pb-4">
                                 <div class="media">
                                    <a href="#"><img alt="Generic placeholder image" src="img/user/6.png" class="mr-3 rounded-pill"></a>
                                    <div class="media-body">
                                       <div class="reviews-members-header">
                                          <span class="star-rating float-right">
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating active"></i></a>
                                          <a href="#"><i class="icofont-ui-rating"></i></a>
                                          </span>
                                          <h6 class="mb-1"><a class="text-black" href="#">Gurdeep Singh</a></h6>
                                          <p class="text-gray">Tue, 20 Mar 2020</p>
                                       </div>
                                       <div class="reviews-members-body">
                                          <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                                       </div>
                                       <div class="reviews-members-footer">
                                          <a class="total-like" href="#"><i class="icofont-thumbs-up"></i> 88K</a> <a class="total-like" href="#"><i class="icofont-thumbs-down"></i> 1K</a> 
                                          <span class="total-like-user-main ml-2" dir="rtl">
                                          <a data-toggle="tooltip" data-placement="top" title="Gurdeep Osahan" href="#"><img alt="Generic placeholder image" src="img/user/5.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Gurdeep Singh" href="#"><img alt="Generic placeholder image" src="img/user/2.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Askbootstrap" href="#"><img alt="Generic placeholder image" src="img/user/3.png" class="total-like-user rounded-pill"></a>
                                          <a data-toggle="tooltip" data-placement="top" title="Osahan" href="#"><img alt="Generic placeholder image" src="img/user/4.png" class="total-like-user rounded-pill"></a>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <a class="text-center w-100 d-block mt-4 font-weight-bold" href="#">See All Reviews</a>
                           </div>
                           <div class="bg-white rounded shadow-sm p-4 mb-5 rating-review-select-page">
                              <h5 class="mb-4">Leave Comment</h5>
                              <p class="mb-2">Rate the Place</p>
                              <div class="mb-4">
                                 <span class="star-rating">
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 <a href="#"><i class="icofont-ui-rating icofont-2x"></i></a>
                                 </span>
                              </div>
                              <form>
                                 <div class="form-group">
                                    <label>Your Comment</label>
                                    <textarea class="form-control"></textarea>
                                 </div>
                                 <div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="button"> Submit Comment </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="col-md-4">
                  <div class="pb-2">
				         <div class="bg-white rounded shadow-sm text-white mb-4 p-4 clearfix restaurant-detailed-earn-pts card-icon-overlap">
                     <img class="img-fluid float-left mr-3" src="img/earn-score-icon.png">
                     <h6 class="pt-0 text-primary mb-1 font-weight-bold">OFFER</h6>
                     <p class="mb-0">60% off on orders above $99 | Use coupon <span class="text-danger font-weight-bold">OSAHAN50</span></p>
                     <div class="icon-overlap">
                        <i class="icofont-sale-discount"></i>
                     </div>
                  </div> -->
                  
				 <!--  </div> -->
                  <!-- <div class="generator-bg rounded shadow-sm mb-4 p-4 osahan-cart-item">
                     <h5 class="mb-1 text-white">Your Order</h5>
                     <p class="mb-4 text-white">6 ITEMS</p>
                     <div class="bg-white rounded shadow-sm mb-2">
                        <div class="gold-members p-2 border-bottom">
                           <p class="text-gray mb-0 float-right ml-2">$314</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-danger food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Chicken Tikka Sub</p>
                              </div>
                           </div>
                        </div>
                        <div class="gold-members p-2 border-bottom">
                           <p class="text-gray mb-0 float-right ml-2">$260</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-success food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Cheese corn Roll</p>
                              </div>
                           </div>
                        </div>
                        <div class="gold-members p-2 border-bottom">
                           <p class="text-gray mb-0 float-right ml-2">$260</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-success food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Cheese corn Roll</p>
                              </div>
                           </div>
                        </div>
                        <div class="gold-members p-2 border-bottom">
                           <p class="text-gray mb-0 float-right ml-2">$056</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-success food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Coke [330 ml]</p>
                              </div>
                           </div>
                        </div>
                        <div class="gold-members p-2 border-bottom">
                           <p class="text-gray mb-0 float-right ml-2">$652</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-danger food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Black Dal Makhani</p>
                              </div>
                           </div>
                        </div>
                        <div class="gold-members p-2">
                           <p class="text-gray mb-0 float-right ml-2">$122</p>
                           <span class="count-number float-right">
                           <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                           <input class="count-number-input" type="text" value="1" readonly="">
                           <button class="btn btn-outline-secondary btn-sm right inc"> <i class="icofont-plus"></i> </button>
                           </span>
                           <div class="media">
                              <div class="mr-2"><i class="icofont-ui-press text-danger food-item"></i></div>
                              <div class="media-body">
                                 <p class="mt-1 mb-0 text-black">Mixed Veg</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mb-2 bg-white rounded p-2 clearfix">
                        <img class="img-fluid float-left" src="img/wallet-icon.png">
                        <h6 class="font-weight-bold text-right mb-2">Subtotal : <span class="text-danger">$456.4</span></h6>
                        <p class="seven-color mb-1 text-right">Extra charges may apply</p>
                        <p class="text-black mb-0 text-right">You have saved $955 on the bill</p>
                     </div>
                     <a href="checkout.html" class="btn btn-success btn-block btn-lg">Checkout <i class="icofont-long-arrow-right"></i></a>
                  </div> -->
				  
				  <div class="text-center pt-2 mb-4">
				  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
               <!-- Lateral Desk -->
               <ins class="adsbygoogle"
                  style="display:block"
                  data-ad-client="ca-pub-3780305514757482"
                  data-ad-slot="8834453972"
                  data-ad-format="auto"
                  data-full-width-responsive="true"></ins>
               <script>
                  (adsbygoogle = window.adsbygoogle || []).push({});
               </script>
				  </div>
				  
               </div>
            </div>
         </div>
      </section>
        
    {% include 'partials/desktop/footerParcial.twig.php' %}

{% endif %}

{% endblock %}