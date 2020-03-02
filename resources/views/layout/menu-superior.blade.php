
@if((Session::get('tipo') == 0))
<style media="screen">
    .menu-superior{
        background-image: -webkit-gradient(linear,right top,left top,from(#dc2424  ),to(#4a569d));
        background-image: -webkit-linear-gradient(right,#dc2424   0,#4a569d 100%);
        background-image: -moz-linear-gradient(right,#dc2424   0,#4a569d 100%);
        background-image: -o-linear-gradient(right,#dc2424   0,#4a569d 100%);
        background-image: linear-gradient(to left,#dc2424   0,#4a569d 100%);
        background-repeat: repeat-x;
        026cb6
    }
</style>
@elseif((Session::get('tipo') == 1))
<style media="screen">
    .menu-superior{
        background-image: -webkit-gradient(linear,right top,left top,from(#009fc5),to(#3cecb0));
        background-image: -webkit-linear-gradient(right,#009fc5 0,#3cecb0 100%);
        background-image: -moz-linear-gradient(right,#009fc5 0,#3cecb0 100%);
        background-image: -o-linear-gradient(right,#009fc5 0,#3cecb0 100%);
        background-image: linear-gradient(to left,#009fc5 0,#3cecb0 100%);
        background-repeat: repeat-x;
        026cb6
    }
</style>
@else
<style media="screen">
   .menu-superior{
       background-image: -webkit-gradient(linear,right top,left top,from(#7956ec ),to(#2fb9f8));
       background-image: -webkit-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
       background-image: -moz-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
       background-image: -o-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
       background-image: linear-gradient(to left,#7956ec  0,#2fb9f8 100%);
       background-repeat: repeat-x;
       026cb6
   }
</style>

@endif
    <!-- <style media="screen">
        .menu-superior{
            background-image: -webkit-gradient(linear,right top,left top,from(#7956ec ),to(#2fb9f8));
            background-image: -webkit-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
            background-image: -moz-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
            background-image: -o-linear-gradient(right,#7956ec  0,#2fb9f8 100%);
            background-image: linear-gradient(to left,#7956ec  0,#2fb9f8 100%);
            background-repeat: repeat-x;
            026cb6
        }
    </style> -->

    <!-- <style media="screen">
        .menu-superior{
            background-image: -webkit-gradient(linear,right top,left top,from(#f23673),to(#ffc066));
            background-image: -webkit-linear-gradient(right,#f23673 0,#ffc066 100%);
            background-image: -moz-linear-gradient(right,#f23673 0,#ffc066 100%);
            background-image: -o-linear-gradient(right,#f23673 0,#ffc066 100%);
            background-image: linear-gradient(to left,#f23673 0,#ffc066 100%);
            background-repeat: repeat-x;
            026cb6
        }
    </style> -->




<nav id="menu-superior" class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-light bg-gradient-x-grey-blue menu-superior" style="">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav">
        <li class="nav-item mobile-menu hidden-md-up float-xs-left">
            <a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs">
                <i class="ft-menu font-large-1"></i>
            </a>
        </li>
        <li class="nav-item">
          <a href="#" class="navbar-brand">

          </a>
        </li>
        <li class="nav-item hidden-md-up float-xs-right">
          <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
        </li>
      </ul>
    </div>
    <div class="navbar-container content container-fluid">
      <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
        <ul class="nav navbar-nav">
          <li class="nav-item hidden-sm-down">
              <a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu"></i>
              </a>
          </li>

          <li class="nav-item hidden-sm-down">
              <a href="#" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i>
              </a>
          </li>
        </ul>
        <ul class="nav navbar-nav float-xs-right">


            <li class="dropdown dropdown-user nav-item">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                  <span class="avatar avatar-online">
                      <!-- <img src="{{asset('')}}" alt="avatar"> -->
                      <img src="{{asset('/avatars/logo2.png')}}" alt="avatar">
                      <!-- imamgem de perfil -->
                      <i></i>
                  </span>
                  <span class="user-name" style="padding-top: 0px; padding-bottom: 3px;">
                          {{strtoupper(Auth::user()->usuario) }}
                  </span>
              </a>

              <div class="dropdown-menu dropdown-menu-right">
                  <!-- <a class="dropdown-item" href="/novaSenha">Nova Senha</a>
                  <a class="dropdown-item" href="/MinhaConta">
                      <i class="fa fa-retweet fa-menu"></i>Atualizar Dados
                  </a> -->
                  <a  href="/logout" class="dropdown-item">
                      <i class="fa fa-power-off fa-menu"></i> Sair
                  </a>


              </div>

            </li>

        </ul>
      </div>
    </div>
  </div>
</nav>
