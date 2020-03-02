@extends("layout.template")
@section("conteudo")


<div id="empresa">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Empresas</h3>
            <div class="row breadcrumbs-top container">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="\">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Empresas</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalEmpresa" data-toggle="tooltip" data-placement="top" title="Editar Residente">Nova Empresas</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Lista de Empresas</h4>
        </div>
        <div class="card-body collapse in">
            <div class="table-responsive card-block">

                <table class="table table-hover table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Razão Social</th>
                            <th>Nome Fantasia</th>
                            <th>CNPJ</th>
                            <th>Endereço</th>
                            <th>Estado</th>
                            <th>Cidada</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="empresa in empresaPaginate.data">

                            <td class="vertical-align-middle " >@{{empresa.id}}</td>
                            <td class="vertical-align-middle " >@{{empresa.razao_social}}</td>
                            <td class="vertical-align-middle " >@{{empresa.nome_fantasia}}</td>
                            <td class="vertical-align-middle " >@{{empresa.cnpj}}</td>
                            <td class="vertical-align-middle " >@{{empresa.endereco}}</td>
                            <td class="vertical-align-middle " >@{{empresa.has_estado.nome}}</td>
                            <td class="vertical-align-middle " >@{{empresa.has_cidade.nome}}</td>

                            <td class="text-center vertical-align-middle "  v-if="empresa.status == 1"><span class="tag tag-success tag-sm"><strong>Ativo</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="empresa.status == 0"><span class="tag tag-danger tag-sm"><strong>Inativo</strong></span></td>

                            <td class="text-center vertical-align-middle ">
                                <button type="button" class="btn btn-tn btn-warning has-tooltip" v-on:click="getEmpresas('',empresa.id)"  data-toggle="modal" data-target="#modalEditEmpresa" data-toggle="tooltip" data-placement="top" title="Editar Empresa "><i class="fa fa-pencil-square-o"></i></button>
                                <button v-if="empresa.status == 1" type="button" class="btn btn-tn btn-danger has-tooltip" v-on:click="desativaEmpresa(empresa.id)"  data-toggle="tooltip" data-placement="top" title="Desativar Empresa"><i class="fa fa-user-times"></i></button>
                                <button v-if="empresa.status == 0" type="button" class="btn btn-tn btn-success has-tooltip" v-on:click="ativarEmpresa(empresa.id)" data-toggle="tooltip" data-placement="top" title="Ativar Empresa"><i class="fa fa-user-plus"></i></button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="text-xs-center mb-3" v-if="empresaPaginate.data" >
        <nav aria-label="Page navigation" v-if="empresaPaginate.data.length != 0">
            <ul class="pagination pagination-sm">
                <li class="page-item" v-if="empresaPaginate.current_page != 1">
                    <a class="page-link" @click="getEmpresas(empresaPaginate.current_page-1,'')" aria-label="Previous">«</a>
                </li>
                <li class="page-item" v-for="n in getPages()" :class="{'active' : empresaPaginate.current_page == n}">
                    <a class="page-link" @click="getEmpresas(n,'')">@{{n}}</a>
                </li>
                <li class="page-item" v-if="empresaPaginate.current_page != empresaPaginate.last_page">
                    <a class="page-link" @click="getEmpresas(empresaPaginate.current_page+1,'')" aria-label="Next">»</a>
                </li>
            </ul>
        </nav>
    </div>




    @include('empresas.cad-empresa')
    @include('empresas.edit-empresa')


</div>




<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);
Vue.use(VueLoading);
Vue.component('loading', VueLoading);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#empresa',
    data: {
        urlBase            : "{{url('')}}",
        empresa            : '',
        edit_empresa       : '',
        empresaPaginate    : '',
        por_pagina         : 10,
        limit              : 5,
        nova_empresa       :{
            estado_id:'',
            cidade_id:'',
        },
        editar_empresa       :{
            estado_id:'',
            cidade_id:'',
        },
        estados            :'',
        cidades            :'',
        usuario            : '',
        senha              : '',
        rsenha             : '',

    },
    components: {
        Loading: VueLoading
    },
    methods: {

        getEstados : function (){
            url = this.urlBase+"/estados";
            this.$http.get(url).then( response => {
                this.estados = response.body;
                this.cidade = '';
            });
        },

        getCidade : function (){

            estado = this.nova_empresa.estado_id;

            url = this.urlBase+"/cidades/"+estado;
            this.$http.get(url).then( response => {
                this.cidades = response.body;
            });

        },

        cadastrar : function(){
            // console.log(this.nova_empresa.nome_fantasia);
            if(this.nova_empresa.nome_fantasia == '' || this.nova_empresa.nome_fantasia == null){
                Swal.fire('Campo Nome Fantasia é obrigatorio','','error');
                return false;
            }if(this.nova_empresa.razao_social == '' || this.nova_empresa.razao_social == null){
                Swal.fire('Campo Razão Social é obrigatorio','','error');
                return false;
            }if(this.nova_empresa.cnpj == '' || this.nova_empresa.cnpj == null){
                Swal.fire('Campo CNPJ é obrigatorio','','error');
                return false;
            }if(this.nova_empresa.endereco == '' || this.nova_empresa.endereco == null){
                Swal.fire('Campo Endereço é obrigatorio','','error');
                return false;
            }if(this.usuario == '' || this.usuario == null){
                Swal.fire('Campo Usuario é obrigatorio','','error');
                return false;
            }if(this.senha == '' ||this.senha == null){
                Swal.fire('Campo senha é obrigatorio','','error');
                return false;
            }if(this.rsenha == '' || this.rsenha ==  null){
                Swal.fire('Confirme sua Senha','','error');
                return false;
            }if(this.rsenha != this.senha){
                Swal.fire('As senhas não coincidem','','error');
                this.rsenha = null;
                return false;
            }

            url = this.urlBase + '/empresa';

            nova_empresa = {
                nome_fantasia : this.nova_empresa.nome_fantasia,
                razao_social  : this.nova_empresa.razao_social,
                cnpj          : this.nova_empresa.cnpj,
                endereco      : this.nova_empresa.endereco,
                estado_id     : this.nova_empresa.estado_id,
                cidade_id     : this.nova_empresa.cidade_id,
                cep           : this.nova_empresa.cep
            };

            novo_usuario = {
                usuario    : this.usuario,
                senha      : this.senha
            };


            this.$http.post(url, {nova_empresa:nova_empresa,novo_usuario:novo_usuario})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');

                    this.nova_empresa.nome_fantasia = '';
                    this.nova_empresa.razao_social  = '';
                    this.nova_empresa.cnpj          = '';
                    this.nova_empresa.endereco      = '';
                    this.nova_empresa.estado_id     = '';
                    this.nova_empresa.cidade_id     = '';
                    this.nova_empresa.cep           = '';

                    this.usuario = '';
                    this.senha   = '';
                    this.rsenha  = '';


                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })


        },

        getEmpresas : function (numeroPagina='',id=''){
            let loader = this.$loading.show({loader: 'dots' });

            if(id){
                url = this.urlBase+"/empresa/"+id;
            }else{
                url = this.urlBase+"/empresa";
            }
            if(numeroPagina){
                url = url+"?page="+numeroPagina;
            }

            if(id){
                this.$http.get(url).then( response => {
                    this.edit_empresa =  response.body;
                    console.log(response.body);

                     url = this.urlBase+"/cidades/"+this.edit_empresa.estado_id;
                     this.$http.get(url).then( response => {
                         this.cidades = response.body;
                     });

                });
            }else{
                this.$http.get(url).then( response => {
                    this.empresaPaginate = response.body;
                    this.por_pagina = this.empresaPaginate.per_page;
                    this.pegaFiliais();
                });
            }

            loader = loader.hide();
        },

        pegaFiliais : function () {
            this.empresa = (this.empresaPaginate.data) ? this.empresaPaginate.data : this.empresaPaginate;
        },

        getPages: function() {
            if (this.limit === -1) { return 0; }
            if (this.limit === 0) { return this.empresaPaginate.last_page; }
            var start = this.empresaPaginate.current_page - this.limit,
            end   = this.empresaPaginate.current_page + this.limit + 1,
            pages = [],
            index;
            start = start < 1 ? 1 : start;
            end   = end >= this.empresaPaginate.last_page ? this.empresaPaginate.last_page + 1 : end;
            for (index = start; index < end; index++) {
                pages.push(index);
            }
            return pages;
        },

        editar : function(){
            url = this.urlBase + '/empresa';
            this.$http.put(url, {empresa: this.edit_empresa})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.getEmpresas();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })

        },

        ativarEmpresa : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Ativar Empresa !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/empresa/ativar/empresa/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getEmpresas();
                        }else{
                            Swal.fire(response.body.msg,'','error');
                        }

                    });
                }
            })
        },

        desativaEmpresa : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Desativar Comerciante !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/empresa/desativar/empresa/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getEmpresas();
                        }else{
                            Swal.fire(response.body.msg,'','error');
                        }
                    });
                }
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
        let loader = this.$loading.show({loader: 'dots' });
        this.getEmpresas();
        this.getEstados();
        loader = loader.hide();

    }
}
)
</script>
@endsection
