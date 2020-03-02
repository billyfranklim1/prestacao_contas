@extends("layout.template")
@section("conteudo")


<div id="filial">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Filiais</h3>
            <div class="row breadcrumbs-top container">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="\">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Filiais</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalFilial" data-toggle="tooltip" data-placement="top" title="Nova Filial">Nova Filial</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Lista de Filiais</h4>
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
                        <tr v-for="filial in filialPaginate.data">

                            <td class="vertical-align-middle " >@{{filial.id}}</td>
                            <td class="vertical-align-middle " >@{{filial.razao_social}}</td>
                            <td class="vertical-align-middle " >@{{filial.nome_fantasia}}</td>
                            <td class="vertical-align-middle " >@{{filial.cnpj}}</td>
                            <td class="vertical-align-middle " >@{{filial.endereco}}</td>
                            <td class="vertical-align-middle " >@{{filial.has_estado.nome}}</td>
                            <td class="vertical-align-middle " >@{{filial.has_cidade.nome}}</td>

                            <td class="text-center vertical-align-middle "  v-if="filial.status == 1"><span class="tag tag-success tag-sm"><strong>Ativo</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="filial.status == 0"><span class="tag tag-danger tag-sm"><strong>Inativo</strong></span></td>

                            <td class="text-center vertical-align-middle ">
                                <button type="button" class="btn btn-tn btn-warning has-tooltip" v-on:click="getFiliais('',filial.id)"  data-toggle="modal" data-target="#modalEditFilial" data-toggle="tooltip" data-placement="top" title="Editar Filial "><i class="fa fa-pencil-square-o"></i></button>
                                <button v-if="filial.status == 1" type="button" class="btn btn-tn btn-danger has-tooltip" v-on:click="desativaFilial(filial.id)"  data-toggle="tooltip" data-placement="top" title="Desativar Filial"><i class="fa fa-user-times"></i></button>
                                <button v-if="filial.status == 0" type="button" class="btn btn-tn btn-success has-tooltip" v-on:click="ativarFilial(filial.id)" data-toggle="tooltip" data-placement="top" title="Ativar Filial"><i class="fa fa-user-plus"></i></button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="text-xs-center mb-3" v-if="filialPaginate.data" >
        <nav aria-label="Page navigation" v-if="filialPaginate.data.length != 0">
            <ul class="pagination pagination-sm">
                <li class="page-item" v-if="filialPaginate.current_page != 1">
                    <a class="page-link" @click="getFiliais(filialPaginate.current_page-1,'')" aria-label="Previous">«</a>
                </li>
                <li class="page-item" v-for="n in getPages()" :class="{'active' : filialPaginate.current_page == n}">
                    <a class="page-link" @click="getFiliais(n,'')">@{{n}}</a>
                </li>
                <li class="page-item" v-if="filialPaginate.current_page != filialPaginate.last_page">
                    <a class="page-link" @click="getFiliais(filialPaginate.current_page+1,'')" aria-label="Next">»</a>
                </li>
            </ul>
        </nav>
    </div>




    @include('filiais.cad-filial')
    @include('filiais.edit-filial')


</div>




<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);
Vue.use(VueLoading);
Vue.component('loading', VueLoading);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#filial',
    data: {
        urlBase            : "{{url('')}}",
        filial             : '',
        edit_filial        : '',
        filialPaginate     : '',
        por_pagina         : 10,
        limit              : 5,
        nova_filial        :{
            estado_id:'',
            cidade_id:'',
        },
        editar_filial      :{
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

            estado = this.nova_filial.estado_id;

            url = this.urlBase+"/cidades/"+estado;
            this.$http.get(url).then( response => {
                this.cidades = response.body;
            });

        },

        cadastrar : function(){
            // console.log(this.nova_filial.nome_fantasia);
            if(this.nova_filial.nome_fantasia == '' || this.nova_filial.nome_fantasia == null){
                Swal.fire('Campo Nome Fantasia é obrigatorio','','error');
                return false;
            }if(this.nova_filial.razao_social == '' || this.nova_filial.razao_social == null){
                Swal.fire('Campo Razão Social é obrigatorio','','error');
                return false;
            }if(this.nova_filial.cnpj == '' || this.nova_filial.cnpj == null){
                Swal.fire('Campo CNPJ é obrigatorio','','error');
                return false;
            }if(this.nova_filial.endereco == '' || this.nova_filial.endereco == null){
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

            url = this.urlBase + '/filial';

            nova_filial = {
                nome_fantasia : this.nova_filial.nome_fantasia,
                razao_social  : this.nova_filial.razao_social,
                cnpj          : this.nova_filial.cnpj,
                endereco      : this.nova_filial.endereco,
                estado_id     : this.nova_filial.estado_id,
                cidade_id     : this.nova_filial.cidade_id,
                cep           : this.nova_filial.cep
            };

            novo_usuario = {
                usuario    : this.usuario,
                senha      : this.senha
            };


            this.$http.post(url, {nova_filial:nova_filial,novo_usuario:novo_usuario})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');

                    this.nova_filial.nome_fantasia = '';
                    this.nova_filial.razao_social  = '';
                    this.nova_filial.cnpj          = '';
                    this.nova_filial.endereco      = '';
                    this.nova_filial.estado_id     = '';
                    this.nova_filial.cidade_id     = '';
                    this.nova_filial.cep           = '';

                    this.usuario = '';
                    this.senha   = '';
                    this.rsenha  = '';

                    this.getFiliais();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })


        },

        getFiliaisByStts : function (stts){
            let loader = this.$loading.show({loader: 'dots' });
            this.stts = stts;
            url = this.urlBase+"/filial/stts/"+stts;
            this.$http.get(url).then((response) => {
                this.filialPaginate = response.body;
                this.por_pagina = this.filialPaginate.per_page;
                this.pegaFiliais();
            });
            loader = loader.hide();
        },

        getFiliais : function (numeroPagina='',id=''){
            let loader = this.$loading.show({loader: 'dots' });

            if(id){
                url = this.urlBase+"/filial/"+id;
            }else{
                url = this.urlBase+"/filial";
            }
            if(numeroPagina){
                url = url+"?page="+numeroPagina;
            }

            if(id){
                this.$http.get(url).then( response => {
                    this.edit_filial =  response.body;

                     url = this.urlBase+"/cidades/"+this.edit_filial.estado_id;
                     this.$http.get(url).then( response => {
                         this.cidades = response.body;
                     });

                });
            }else{
                this.$http.get(url).then( response => {
                    this.filialPaginate = response.body;
                    this.por_pagina = this.filialPaginate.per_page;
                    this.pegaFiliais();
                });
            }

            loader = loader.hide();
        },

        pegaFiliais : function () {
            this.filial = (this.filialPaginate.data) ? this.filialPaginate.data : this.filialPaginate;
        },

        getPages: function() {
            if (this.limit === -1) { return 0; }
            if (this.limit === 0) { return this.filialPaginate.last_page; }
            var start = this.filialPaginate.current_page - this.limit,
            end   = this.filialPaginate.current_page + this.limit + 1,
            pages = [],
            index;
            start = start < 1 ? 1 : start;
            end   = end >= this.filialPaginate.last_page ? this.filialPaginate.last_page + 1 : end;
            for (index = start; index < end; index++) {
                pages.push(index);
            }
            return pages;
        },

        editar : function(){
            url = this.urlBase + '/filial';
            this.$http.put(url, {filial: this.edit_filial})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.getFiliais();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })

        },

        ativarFilial : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Ativar Filial !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/filial/ativar/filial/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getFiliais();
                        }else{
                            Swal.fire(response.body.msg,'','error');
                        }

                    });
                }
            })
        },

        desativaFilial : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Desativar Comerciante !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/filial/desativar/filial/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getFiliais();
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
        this.getFiliais();
        this.getEstados();
        loader = loader.hide();

    }
}
)
</script>
@endsection
