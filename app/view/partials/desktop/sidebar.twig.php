<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="/img/logo-pb.png" class="img-fluid">
                </div>
            </a>
            <!-- Nav Item - Home -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="mdi mdi-home-variant-outline"></i>
                    <span>{{ trans.t('Home') }} </span></a>
            </li>
            <!-- Nav Item - Explore -->
            <li class="nav-item">
                <a class="nav-link" href="explore.html">
                    <i class="mdi mdi-grid-large"></i>
                    <span>{{ trans.t('Perto de você')}}</span></a>
            </li>
            <!-- Nav Item - Orders -->
            <li class="nav-item">
                <a class="nav-link" href="orders.html">
                    <i class="mdi mdi-book-open"></i>
                    <span>{{ trans.t('Meus Pedidos')}}</span></a>
            </li>
            <!-- Nav Item - Favourities -->
            <li class="nav-item">
                <a class="nav-link" href="favourities.html">
                    <i class="mdi mdi-bookmark-outline"></i>
                    <span>{{ trans.t('Favoritos')}}</span></a>
            </li>
            
            <!-- Nav Item - Messages -->
            <li class="nav-item">
                <a class="nav-link d-flex" href="messages.html">
                    <i class="mdi mdi-message-text-outline mr-2"></i>
                    <span>{{ trans.t('Mensagens')}}</span>
                    <span class="rounded-circle bg-white text-primary ml-auto px-2 py-1">2</span></a>
            </li>
            <!-- Nav Item - Settings -->
            <li class="nav-item">
                <a class="nav-link" href="settings.html">
                    <i class="mdi mdi-cog"></i>
                    <span>{{ trans.t('Meu Perfil')}}</span></a>
            </li>
            
            <!-- offers -->
            <div class="bg-white m-3 p-3 sidebar-alert rounded text-center alert fade show d-none d-md-inline" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <i class="mdi mdi-food mb-3"></i>
                <p class="text-black mb-1">Free delivery on<br>all orders over <span class="text-primary">$25</span></p>
                <p class="small">It is a limited time offer that will expire soon.</p>
                <a href="explore.html" class="btn btn-primary btn-block btn-sm">Order now <i class="pl-3 fas fa-long-arrow-alt-right"></i></a>
            </div>
            <!-- User -->
            <div class="d-none d-md-block">
                <div class="user d-flex align-items-center p-3">
                    <div class="pr-3"><i class="mdi mdi-account-circle-outline text-white h3 mb-0"></i></div>
                    <div>
                        <p class="mb-0 text-white">{{usuario[':nome']}}</p>
                        <p class="mb-0 text-white-50 small">Telefone: {{usuario[':telefone']}}</p>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>