<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prestação de Contas</title>
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body >

    <div id="login" class="main" style="padding: 100px 0px;">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content"  style="padding: 10px 0px;">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <br>
                        <br>

                        <h2 class="form-title">ENTRAR</h2>
                        <div class="register-form" id="login-form" >
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <!-- <input autocomplete="off" type="text" name="your_name" id="your_name" v-mask="'##.###.###/####-##'" v-model="cnpj" placeholder="Seu CNPJ"/> -->
                                <input autocomplete="off" type="text" name="your_name" id="your_pass" v-model="usuario" placeholder="Seu Usuario" v-on:keyup.enter="login"/>

                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input autocomplete="off" type="password" name="your_pass" id="your_pass" v-model="senha" placeholder="Sua Senha" v-on:keyup.enter="login"/>
                            </div>

                            <div class="form-group form-button">
                                <button type="button"  v-on:keyup.enter="submit" class="form-submit btn btn-primary" v-on:click="login()" v-on:keyup.enter="login()"  ><i class="ft-unlock"></i>Entrar</button>

                            </div>
                        </div>
            </div>
        </div>
    </div>
</section>

</div>

<!-- JS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script type="text/javascript">
Vue.directive('mask', VueMask.VueMaskDirective);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#login',
    data: {
        urlBase       : "{{url('')}}",
        cnpj          :'',
        usuario    :'',
        senha         :'',
        tipo          :'2',
        matriz_filial :'1',

    },
    methods: {
        login : function(){
            if(this.usuario == '' || null){
                Swal.fire('Campo Usuario é obrigatorio','','error');
                return false;
            }if(this.senha == '' || null){
                Swal.fire('Campo Senha é obrigatorio','','error');
                return false;
            }

            url = this.urlBase + '/logar';
            if(this.tipo == 1){
                if(this.matriz_filial == 1){
                    tipo = 1;
                }else{
                    tipo = 3;
                }
            }else{
                tipo = 2;
            }
            this.$http.post(url, {usuario: this.usuario,senha:this.senha})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(response.body.msg,'','success');
                    window.location.href = this.urlBase+'/home';
                }else{
                    Swal.fire(response.body.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })


        },


    },
    filters : {
        formataData: function (value) {
            if (value) {
                return moment(String(value)).format('L');
            }
            return "";
        }
    },
    created : function() {
    }
}
)
</script>
