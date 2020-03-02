<!DOCTYPE html>
<html lang="pt-br" data-textdirection="ltr" class="loading">
<head>
    <!-- <link href="{{ asset('css/fab.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <!-- <meta name="_token" content="{{ csrf_token() }}"> -->
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="shortcut icon" href="{{asset('assets/img/crypta/favicon.png')}}" /> -->
    <!-- <link rel="apple-touch-icon" href="{{asset('assets/img/crypta/favicon.png')}}" /> -->
    <title>Prestação de Contas</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
    rel="stylesheet">


    <!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

    <script src="{{asset('js/vue.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/vue-resource-develop/dist/vue-resource.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/v-mask-2.0.2/dist/v-mask.min.js')}}" type="text/javascript"></script>

    <!-- <script src="{{asset('/app-assets/js/scripts/modal/components-modal.min.js')}}"></script> -->

    <!-- <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/components.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/colors/palette-gradient.min.css')}}">

    <script src="{{asset('/app-assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/core/app-menu.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/core/app.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/customizer.min.js')}}"></script>

    <script
      src="https://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"></script> -->


    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/fonts/feather/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/fonts/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/pace.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/charts/morris.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/unslider.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/weather-icons/climacons.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/fonts/simple-line-icons/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/plugins/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/colors/palette-gradient.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/fonts/simple-line-icons/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/core/colors/palette-gradient.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/pages/timeline.min.css')}}">

@yield('style')

<script type="text/javascript">
let urlBase = "{{url('')}}";
</script>
<script src="{{asset('/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>

</script>
@yield('scriptSuperior')
<!-- <script src="{{asset('/assets/js/build.js')}}"></script> -->
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar @if(Route::current()->getName() == 'dashboard') back @endif">
    <!-- Menu superior-->
    @include('layout.menu-superior')
    <!-- ///////////////////////////// Menu esquerdo ///////////////////////////////////////////////-->
    @include('layout.menu-esquerdo')
    <div class="app-content content container-fluid" >
        <div class="content-wrapper">
            <div class="content-body back">
                @yield('conteudo')
            </div>
        </div>
    </div>

    <!-- ////////////////////////////////// Rodapé //////////////////////////////////////////-->
    @include('layout.rodape')
    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{asset('/app-assets/js/core/app.js')}}" type="text/javascript"></script>
    <script src="{{asset('/app-assets/vendors/js/extensions/toastr.min.js')}}" type="text/javascript"></script>

    @yield('script')


</body>
</html>
