{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTop.twig.php' %}
<section class="section pt-5 pb-5">
         <div class="container">
            <div class="row">
               <div class="col-md-8 mx-auto bg-white p-5 rounded">
                  <h1>Example heading <span class="badge badge-secondary">New</span></h1>
                  <h2>Example heading <span class="badge badge-secondary">New</span></h2>
                  <h3>Example heading <span class="badge badge-secondary">New</span></h3>
                  <h4>Example heading <span class="badge badge-secondary">New</span></h4>
                  <h5>Example heading <span class="badge badge-secondary">New</span></h5>
                  <h6>Example heading <span class="badge badge-secondary">New</span></h6>
                  <hr/>
                  <button type="button" class="btn btn-primary">
                  Notifications <span class="badge badge-light">4</span>
                  </button>
                  <hr/>
                  <span class="badge badge-primary">Primary</span>
                  <span class="badge badge-secondary">Secondary</span>
                  <span class="badge badge-success">Success</span>
                  <span class="badge badge-danger">Danger</span>
                  <span class="badge badge-warning">Warning</span>
                  <span class="badge badge-info">Info</span>
                  <span class="badge badge-light">Light</span>
                  <span class="badge badge-dark">Dark</span>
                  <hr/>
                  <span class="badge badge-pill badge-primary">Primary</span>
                  <span class="badge badge-pill badge-secondary">Secondary</span>
                  <span class="badge badge-pill badge-success">Success</span>
                  <span class="badge badge-pill badge-danger">Danger</span>
                  <span class="badge badge-pill badge-warning">Warning</span>
                  <span class="badge badge-pill badge-info">Info</span>
                  <span class="badge badge-pill badge-light">Light</span>
                  <span class="badge badge-pill badge-dark">Dark</span>
                  <hr/>
                  <nav aria-label="breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                     </ol>
                  </nav>
                  <nav aria-label="breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                     </ol>
                  </nav>
                  <nav aria-label="breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                     </ol>
                  </nav>
                  <hr/>
                  <button type="button" class="btn btn-primary">Primary</button>
                  <button type="button" class="btn btn-secondary">Secondary</button>
                  <button type="button" class="btn btn-success">Success</button>
                  <button type="button" class="btn btn-danger">Danger</button>
                  <button type="button" class="btn btn-warning">Warning</button>
                  <button type="button" class="btn btn-info">Info</button>
                  <button type="button" class="btn btn-light">Light</button>
                  <button type="button" class="btn btn-dark">Dark</button>
                  <button type="button" class="btn btn-link">Link</button>
                  <hr/>
                  <button type="button" class="btn btn-outline-primary">Primary</button>
                  <button type="button" class="btn btn-outline-secondary">Secondary</button>
                  <button type="button" class="btn btn-outline-success">Success</button>
                  <button type="button" class="btn btn-outline-danger">Danger</button>
                  <button type="button" class="btn btn-outline-warning">Warning</button>
                  <button type="button" class="btn btn-outline-info">Info</button>
                  <button type="button" class="btn btn-outline-light">Light</button>
                  <button type="button" class="btn btn-outline-dark">Dark</button>
                  <hr/>
                  <div class="alert alert-primary" role="alert">
                     A simple primary alert—check it out!
                  </div>
                  <div class="alert alert-secondary" role="alert">
                     A simple secondary alert—check it out!
                  </div>
                  <div class="alert alert-success" role="alert">
                     A simple success alert—check it out!
                  </div>
                  <div class="alert alert-danger" role="alert">
                     A simple danger alert—check it out!
                  </div>
                  <div class="alert alert-warning" role="alert">
                     A simple warning alert—check it out!
                  </div>
                  <div class="alert alert-info" role="alert">
                     A simple info alert—check it out!
                  </div>
                  <div class="alert alert-light" role="alert">
                     A simple light alert—check it out!
                  </div>
                  <div class="alert alert-dark" role="alert">
                     A simple dark alert—check it out!
                  </div>
                  <hr/>
                  <div class="alert alert-primary" role="alert">
                     A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-secondary" role="alert">
                     A simple secondary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-success" role="alert">
                     A simple success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-danger" role="alert">
                     A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-warning" role="alert">
                     A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-info" role="alert">
                     A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-light" role="alert">
                     A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-dark" role="alert">
                     A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                  </div>
                  <div class="alert alert-success" role="alert">
                     <h4 class="alert-heading">Well done!</h4>
                     <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                     <hr>
                     <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                  </div>
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </section>
{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}