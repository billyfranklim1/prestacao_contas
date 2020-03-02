<div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow" id="menu-esquerdo">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
            <li class=" nav-item">
                <a href="/home">
                    <i class="fa fa-home fa-menu"></i>
                    <span data-i18n="" class="menu-title">Home</span>
                </a>
            </li>

            @if((Auth::user()->usuario == 'admin'))
            <li class=" nav-item">
                <a href="/empresa/list/empresa">
                    <i class="fa fa-building fa-menu"></i>
                    <span data-i18n="" class="menu-title">Empresas</span>
                </a>
            </li>
            @else
                @if((Session::get('tipo') == 1))
                    <li class=" nav-item">
                        <a href="/filial/list/filial">
                            <i class="fa fa-users fa-menu"></i>
                            <span data-i18n="" class="menu-title">Filial</span>
                        </a>
                    </li>
                @endif

                @if((Session::get('tipo') == 2))
                    <li class=" nav-item">
                        <a href="/prestacaoc/list/prestacaoc">
                            <i class="fa fa-th-list fa-menu"></i>
                            <span data-i18n="" class="menu-title">Prestação Contas</span>
                        </a>
                    </li>
                @endif
            @endif







            <li class=" nav-item">
                <a href="/logout">
                    <i class="fa fa-power-off fa-menu"></i>
                    <span data-i18n="" class="menu-title">Sair</span>
                </a>
            </li>

        </ul>
    </div>
</div>
