<div class="bg-primary p-3">
<div class="text-white">
<div class="title d-flex">
<a class="toggle" href="#">
<span></span>
</a>
<h4 class="font-weight-bold m-0 pl-5">Browse</h4>
<a class="text-white font-weight-bold ml-auto" data-toggle="modal" data-target="#exampleModal" href="#">Filter</a>
</div>
</div>
<div class="input-group mt-3 rounded shadow-sm overflow-hidden">
<div class="input-group-prepend">
<button class="border-0 btn btn-outline-secondary text-dark bg-white btn-block"><i class="feather-search"></i></button>
</div>
<input type="text" class="shadow-none border-0 form-control" placeholder="Search for restaurants or dishes" aria-label="" aria-describedby="basic-addon1">
</div>
</div>


<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="{{BASE}}{{empresa.link_site}}/">Automatiza</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{BASE}}{{empresa.link_site}}/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{BASE}}{{empresa.link_site}}/produto/">Produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{BASE}}{{empresa.link_site}}/quem-somos/">Quem Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{BASE}}{{empresa.link_site}}/contato/">Contato</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="get" action="{{BASE}}{{empresa.link_site}}/pesquisa/">
                <input class="form-control mr-sm-2" type="text" placeholder="Pesquisar" name="pes">
                
<button class="btn btn-info my-2 my-sm-0" type="submit">Busc    ar</button>
            </form>
        </div>
    </nav>
</header>