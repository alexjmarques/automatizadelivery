<!-- My items Modal-->
<div class="modal fade" id="myitemsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog border-bottom">
            <div class="modal-content osahan-item-detail-pop">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">Rice choice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body px-3 py-0">
                    <div class="pb-3 position-relative">
                        <div class="position-absolute heart-fav">
                            <a href="#"><i class="mdi mdi-heart"></i></a>
                        </div>
                        <img src="img/food-banner.png" class="img-fluid col-md-12 p-0 rounded">
                    </div>

                    <h4 class="mb-2">Char-Broiled Chicken Shish</h4>
                    <p>Served with basmati rice or bulgur pilaf, skewered with grilled vegetables</p>
                    <div class="d-flex align-items-center mb-3">
                        <p class="text-danger mb-0">Rice choice</p>
                        <p class="bg-primary text-white rounded px-2 py-1 mb-0 small ml-auto">Required</p>
                    </div>
                    <form class="mb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                            <label class="custom-control-label font-weight-bold text-dark" for="customCheck1">Basmati rice</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label font-weight-bold text-dark" for="customCheck2">Brown rice</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                            <label class="custom-control-label font-weight-bold text-dark" for="customCheck3">Bulgur pilaf</label>
                        </div>
                    </form>
                    <p class="mb-0"><a href="#" class="text-decoration-none text-primary"><i class="fas fa-plus mr-2 bg-light rounded p-2"></i> Add special instructions</a></p>
                </div>
                <div class="modal-footer">
                    <button data-toggle="modal" data-target="#cartModal" class="btn btn-primary btn-block">Add ($15.00)</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Filters -->
    <div class="modal fade" id="filtersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search filters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p class="text-dark mb-2 small">Sort by</p>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn osahan-radio btn-light btn-sm active rounded">
                     <input type="radio" name="options" id="option1" checked> <i class="mdi mdi-fire"></i> Most popular
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option2"> <i class="mdi mdi-clock-outline"></i> Delivery time
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option3"> <i class="mdi mdi-star"></i> Rating
                     </label>
                    </div>
                    <p class="text-dark mb-2 small mt-3">Price range</p>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn osahan-radio btn-light active btn-sm rounded">
                     <input type="radio" name="options" id="option1" checked> $
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option2"> $$
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option3"> $$$
                     </label>
                    </div>
                    <p class="text-dark mb-2 small mt-3">Categories</p>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn osahan-radio btn-light active btn-sm rounded">
                     <input type="radio" name="options" id="option1" checked> Burger
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option2"> Fast food
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option3"> American food
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option4"> Pizza
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option5"> Asian
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option6"> Desert
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option7"> Mexican
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option8"> Breakfast
                     </label>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <a href="listing.html" class="btn btn-primary btn-block mt-2">Apply filters</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cart -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">My cart <span class="small">(2 items)</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body osahan-my-cart">
                    <a href="#" class="text-dark d-flex align-items-center mb-3" data-toggle="modal" data-target="#myaddressModal">
                        <div>
                            <p class="mb-0 text-danger">Delivered to</p>
                            <p class="mb-0 small">300 Post Street San Francico, CA</p>
                        </div>
                        <div class="ml-auto">
                            <p class="mb-0 text-info">Edit<i class="mdi h6 m-0 mdi-chevron-right"></i></p>
                        </div>
                    </a>
                    <div class="details-page border-top pt-3 osahan-my-cart-item">
                        <h6 class="mb-3">Pizza Hut</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-2"><img src="img/pizza.png" class="img-fluid rounded"></div>
                            <div class="small text-black-50">1 x</div>
                            <div class="ml-2">
                                <p class="mb-0 text-black">Cheese pie</p>
                                <p class="mb-0 small">$15</p>
                            </div>
                            <a href="#" class="ml-auto"><i class="btn btn-light text-danger mdi mdi-trash-can-outline rounded"></i></a>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-2"><img src="img/burger.png" class="img-fluid rounded"></div>
                            <div class="small text-black-50">2 x</div>
                            <div class="text-dark ml-2">
                                <p class="mb-0 text-black">Peperoni pie</p>
                                <p class="mb-0 small">$23</p>
                            </div>
                            <a href="#" class="ml-auto"><i class="btn btn-light text-danger mdi mdi-trash-can-outline rounded"></i></a>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-2"><img src="img/burger2.png" class="img-fluid rounded"></div>
                            <div class="small text-black-50">3 x</div>
                            <div class="text-dark ml-2">
                                <p class="mb-0 text-black">Osahan Burger</p>
                                <p class="mb-0 small">$50</p>
                            </div>
                            <a href="#" class="ml-auto"><i class="btn btn-light text-danger mdi mdi-trash-can-outline rounded"></i></a>
                        </div>
                        <div class="my-3"><a href="#" data-toggle="modal" data-target="#myitemsModal" class="text-primary"><i class="mdi mdi-plus mr-2"></i> Add more items</a></div>
                        <a href="#" class="d-flex align-items-center mb-3" data-toggle="modal" data-target="#mycoupansModal">
                            <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-motorbike"></i></div>
                            <div>
                                <p class="mb-0 text-dark">Delivery</p>
                                <p class="mb-0 small text-black-50">$0</p>
                            </div>
                        </a>
                        <a href="#" class="d-flex align-items-center mb-3" data-toggle="modal" data-target="#mycoupansModal">
                            <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-percent"></i></div>
                            <div>
                                <p class="mb-0 text-dark">Promo code</p>
                                <p class="mb-0 small text-black-50">HFXWO</p>
                            </div>
                            <div class="ml-auto"><button class="btn btn-primary"><i class="mdi mdi-plus"></i></button></div>
                        </a>
                    </div>
                </div>
                <div class="modal-footer justify-content-start osahan-my-cart-footer">
                    <div class="row w-100">
                        <div class="col-2 px-0"><button class="btn btn-warning btn-block" data-toggle="modal" data-target="#mysplitModal"><i class="mdi mdi-account-plus-outline"></i></button></div>
                        <div class="col-10 pr-0"><button class="btn btn-primary btn-block" data-toggle="modal" data-target="#checkoutModal">Checkout ($53.00)</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Model -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Checkout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p class="text-dark mb-2 small">Payment methods</p>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn osahan-radio btn-light btn-sm rounded active">
                     <input type="radio" name="options" id="option1" checked> <i class="mdi mdi-credit-card-outline"></i> Card
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option2"> <i class="mdi mdi-currency-usd"></i> COD
                     </label>
                        <label class="btn osahan-radio btn-light btn-sm rounded">
                     <input type="radio" name="options" id="option3"> <i class="fab fa-paypal"></i> Paypal
                     </label>
                    </div>
                    <h6 class="mb-3">My cards <span class="small">(2)</span></h6>
                    <div class="btn-group btn-group-toggle osahan-card" data-toggle="buttons">
                        <label class="btn osahan-radio osahan-card-pay btn-light btn-sm rounded mb-2 active w-100">
                       <input type="radio" name="options" id="option1" checked>
                       <div class="d-flex align-items-center card-detials small mb-3">
                          <p class="small"><i class="mdi mdi-chip"></i></p>
                          <p class="ml-auto d-flex align-items-center">
                             <span class="card-no mr-2"><i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i></span>
                             <span class="small">1211</span>
                          </p>
                       </div>
                       <h1 class="mb-0">Mastercard</h1>
                       <p class="small mb-1">Platinum</p>
                       <p class="text-right mb-0"><i class="fab fa-cc-mastercard text-warning"></i></p>
                    </label>
                        <label class="btn osahan-radio osahan-card-pay btn-light btn-sm rounded mb-2 w-100">
                       <input type="radio" name="options" id="option2">
                       <div class="d-flex align-items-center card-detials small mb-3">
                          <p class="small"><i class="mdi mdi-chip"></i></p>
                          <p class="ml-auto d-flex align-items-center">
                             <span class="card-no mr-2"><i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i> <i class="mdi mdi-circle"></i></span>
                             <span class="small">2277</span>
                          </p>
                       </div>
                       <h1 class="mb-0">Visa Debit</h1>
                       <p class="small mb-1">Plantinum</p>
                       <p class="text-right mb-0"><i class="fab fa-cc-visa"></i></p>
                    </label>
                    </div>
                    <a href="#" data-toggle="modal" data-target="#paymentsModal" class="btn btn-light btn-block"><i class="mdi mdi-plus"></i> Add</a>
                </div>
                <div class="modal-footer justify-content-start">
                    <a href="orders.html" class="btn btn-primary btn-block">Confirm payment ($53.00)</a>
                </div>
            </div>
        </div>
    </div>
    <!-- My address-->
    <div class="modal fade" id="myaddressModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delivered address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="inputAddress" class="small font-weight-bold text-dark mb-0">Street Name</label>
                            <input type="text" class="form-control form-control-sm border-0 p-0 border-input rounded-0" id="inputAddress" placeholder="" value="300 Post Street">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="small font-weight-bold text-dark mb-0">City</label>
                            <input type="text" class="form-control form-control-sm border-0 p-0 border-input rounded-0" id="inputAddress" placeholder="" value="San Francisco">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="small font-weight-bold text-dark mb-0">State</label>
                            <input type="text" class="form-control form-control-sm border-0 p-0 border-input rounded-0" id="inputAddress" placeholder="" value="California">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress" class="small font-weight-bold text-dark mb-0">Zip Code</label>
                            <input type="text" class="form-control form-control-sm border-0 p-0 border-input rounded-0" id="inputAddress" placeholder="" value="123456">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-block">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- My Coupan-->
    <div class="modal fade" id="mycoupansModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Enter promo code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div data-dismiss="modal" aria-label="Close" class="card offer-card bg-light border rounded mb-2">
                        <div class="card-body">
                            <h5 class="card-title"><img src="img/bank/1.png"> OSAHANEAT50</h5>
                            <h6 class="card-subtitle mb-2 text-primary">Get 50% OFF on your first osahan eat order</h6>
                            <p class="card-text">Use code OSAHANEAT50 &amp; get 50% off on your first osahan order on Website and Mobile site. Maximum discount: $200</p>
                            <a href="#" class="card-link">APPLY CODE</a>
                            <a href="#" class="card-link">KNOW MORE</a>
                        </div>
                    </div>
                    <div data-dismiss="modal" aria-label="Close" class="card offer-card bg-light border rounded mb-2">
                        <div class="card-body">
                            <h5 class="card-title"><img src="img/bank/2.png"> OSAHANLINE</h5>
                            <h6 class="card-subtitle mb-2 text-primary">Get 20% OFF on your first Osahan Eat order</h6>
                            <p class="card-text">Use code OSAHANEAT50 &amp; get 50% off on your first osahan order on Website and Mobile site. Maximum discount: $200</p>
                            <a href="#" class="card-link">APPLY CODE</a>
                            <a href="#" class="card-link">KNOW MORE</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-block">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- My split order-->
    <div class="modal fade" id="mysplitModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Split order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body split-list">
                    <a href="#" data-dismiss="modal" aria-label="Close" class="text-decoration-none d-flex border rounded p-2 bg-light align-items-center mb-2">
                        <div class="mr-2"><img src="img/user1.png" class="img-fluid rounded-circle"></div>
                        <div class="ml-2">
                            <p class="mb-0 text-dark">Kate Simpson</p>
                            <span class="mb-0 small text-black-50">katesimpson@outlook.com</span>
                        </div>
                    </a>
                    <a href="#" data-dismiss="modal" aria-label="Close" class="text-decoration-none d-flex border rounded p-2 bg-light align-items-center mb-2">
                        <div class="mr-2"><img src="img/user2.png" class="img-fluid rounded-circle"></div>
                        <div class="ml-2">
                            <p class="mb-0 text-dark">Andrew smith</p>
                            <span class="mb-0 small text-black-50">andrew@out.com</span>
                        </div>
                    </a>
                    <a href="#" data-dismiss="modal" aria-label="Close" class="text-decoration-none d-flex border rounded p-2 bg-light align-items-center mb-2">
                        <div class="mr-2"><img src="img/user3.png" class="img-fluid rounded-circle"></div>
                        <div class="ml-2">
                            <p class="mb-0 text-dark">Gurdeep Osahan</p>
                            <span class="mb-0 small text-black-50">iamosahan@out.com</span>
                        </div>
                    </a>
                </div>
                <div class="modal-footer border-0">
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary btn-block">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Saved address Modal-->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Saved addresses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs border-0 mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active border-0 bg-primary text-white rounded small" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home (2)</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link border-0 bg-light text-dark rounded ml-3 small" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Work (2)</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div type="button" data-dismiss="modal" class="d-flex align-items-center mb-2 border rounded p-2">
                                <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-home-variant-outline"></i></div>
                                <div class="w-100">
                                    <p class="mb-0 font-weight-bold text-dark">Home 1</p>
                                    <P class="mb-0 small">775 Cletus Estates Suite 423</P>
                                </div>
                            </div>
                            <div type="button" data-dismiss="modal" class="d-flex align-items-center mb-b border rounded p-2">
                                <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-home-variant-outline"></i></div>
                                <div class="w-100">
                                    <p class="mb-0 font-weight-bold text-dark">Home 2</p>
                                    <P class="mb-0 small">182 Cletus Estates Suite 423</P>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div type="button" data-dismiss="modal" class="d-flex align-items-center mb-2 border rounded p-2">
                                <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-office-building-marker-outline"></i></div>
                                <div class="w-100">
                                    <p class="mb-0 font-weight-bold text-dark">Work 1</p>
                                    <P class="mb-0 small">775 Cletus Estates Suite 423</P>
                                </div>
                            </div>
                            <div type="button" data-dismiss="modal" class="d-flex align-items-center mb-b border rounded p-2">
                                <div class="mr-3 bg-light rounded p-2 osahan-icon"><i class="mdi mdi-office-building-marker-outline"></i></div>
                                <div class="w-100">
                                    <p class="mb-0 font-weight-bold text-dark">Work 2</p>
                                    <P class="mb-0 small">182 Cletus Estates Suite 423</P>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary btn-block">Save Changes</button>
                </div>
            </div>
        </div>