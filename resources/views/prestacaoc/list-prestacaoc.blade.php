@extends("layout.template")
@section("conteudo")


<div id="prestacaoc">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Prestação de Contas</h3>
            <div class="row breadcrumbs-top container">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="\">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Prestação de Contas</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalFilial" data-toggle="tooltip" data-placement="top" title="Nova Filial">Nova Prestação de Conta</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Lista de Prestação de Contas</h4>
        </div>
        <div class="card-body collapse in">
            <div class="table-responsive card-block">

                <table class="table table-hover table-striped  ">
                    <thead>
                        <tr>
                            <th>-</th>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Data Inicio</th>
                            <th>Data Fim</th>
                            <th>Empresa</th>
                            <th>Filial</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="prestacaoc in prestacaocPaginate.data">
                            <td class=" btn-group  vertical-align-middle text-center" role="group" aria-label="Basic example" style="left: 35px">
                                <a :href="'/prestacaoc/relatorio/'+prestacaoc.id" class="btn btn-icon btn-tn btn-success has-tooltip" data-toggle="tooltip" data-placement="top" title="Baixar Relatorio"><i class="fa fa-file-excel-o"></i></a>
                                <a  v-if="prestacaoc.status == 0" :href="'/dprestacaoc/list/dprestacaoc/'+prestacaoc.id" class="btn btn-icon btn-tn btn-info has-tooltip" data-toggle="tooltip" data-placement="top" title="Adicionar Despesa"><i class="fa fa-list"></i></a>
                                <button v-if="prestacaoc.status == 0" type="button" class="btn btn-icon btn-tn btn-warning has-tooltip" v-on:click="getPrestacaoc('',prestacaoc.id)"  data-toggle="modal" data-target="#modalEditPrestacaoc" data-toggle="tooltip" data-placement="top" title="Editar Filial "><i class="fa fa-pencil-square-o"></i></button>
                                <button v-if="prestacaoc.status == 0" type="button" class="btn btn-icon btn-tn btn-danger has-tooltip" v-on:click="finalizarPrestacaoc(prestacaoc.id)"  data-toggle="tooltip" data-placement="top" title="Finalizar Prestação de contas"><i class="fa fa-times"></i></button>
                                <!-- <button v-if="prestacaoc.status == 1" type="button" class="btn btn-tn btn-success has-tooltip" v-on:click="finalizarPrestacaoc(prestacaoc.id)" data-toggle="tooltip" data-placement="top" title="Finalizar Prestação de contas"><i class="fa fa-check"></i></button> -->
                            </td>
                            <td class="vertical-align-middle " >@{{prestacaoc.nsu}}</td>
                            <td class="vertical-align-middle " >@{{prestacaoc.descricao}}</td>
                            <td class="vertical-align-middle " >@{{prestacaoc.dt_ini | formataData}}</td>
                            <td class="vertical-align-middle " >@{{prestacaoc.dt_fim | formataData}}</td>
                            <td class="vertical-align-middle " >@{{prestacaoc.has_empresa.nome_fantasia}}</td>
                            <td class="vertical-align-middle " >@{{prestacaoc.has_filial.nome_fantasia}}</td>

                            <td class="text-center vertical-align-middle "  v-if="prestacaoc.status == 1"><span class="tag tag-danger tag-sm"><strong>FECHADO</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="prestacaoc.status == 0"><span class="tag tag-success tag-sm"><strong>ABERTO</strong></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="text-xs-center mb-3" v-if="prestacaocPaginate.data" >
        <nav aria-label="Page navigation" v-if="prestacaocPaginate.data.length != 0">
            <ul class="pagination pagination-sm">
                <li class="page-item" v-if="prestacaocPaginate.current_page != 1">
                    <a class="page-link" @click="getPrestacaoc(prestacaocPaginate.current_page-1,'')" aria-label="Previous">«</a>
                </li>
                <li class="page-item" v-for="n in getPages()" :class="{'active' : prestacaocPaginate.current_page == n}">
                    <a class="page-link" @click="getPrestacaoc(n,'')">@{{n}}</a>
                </li>
                <li class="page-item" v-if="prestacaocPaginate.current_page != prestacaocPaginate.last_page">
                    <a class="page-link" @click="getPrestacaoc(prestacaocPaginate.current_page+1,'')" aria-label="Next">»</a>
                </li>
            </ul>
        </nav>
    </div>




    @include('prestacaoc.cad-prestacaoc')
    @include('prestacaoc.edit-prestacaoc')


</div>




<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);
Vue.use(VueLoading);
Vue.component('loading', VueLoading);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#prestacaoc',
    data: {
        urlBase            : "{{url('')}}",
        prestacaoc            : '',
        prestacaocPaginate    : '',
        por_pagina         : 10,
        limit              : 5,
        nova_prestacaoc       :{},
        edit_prestacaoc       :{},

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

            estado = this.nova_prestacaoc.estado_id;

            url = this.urlBase+"/cidades/"+estado;
            this.$http.get(url).then( response => {
                this.cidades = response.body;
            });

        },

        cadastrar : function(){

            url = this.urlBase + '/prestacaoc';

            this.$http.post(url, {nova_prestacaoc : this.nova_prestacaoc})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){

                    Swal.fire(this.response.msg,'','success');
                    this.nova_prestacaoc = {};
                    this.getPrestacaoc();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })


        },

        getPrestacaocByStts : function (stts){
            let loader = this.$loading.show({loader: 'dots' });
            this.stts = stts;
            url = this.urlBase+"/prestacaoc/stts/"+stts;
            this.$http.get(url).then((response) => {
                this.prestacaocPaginate = response.body;
                this.por_pagina = this.prestacaocPaginate.per_page;
                this.pegaPrestacaoc();
            });
            loader = loader.hide();
        },

        getPrestacaoc : function (numeroPagina='',id=''){
            let loader = this.$loading.show({loader: 'dots' });

            if(id){
                url = this.urlBase+"/prestacaoc/"+id;
            }else{
                url = this.urlBase+"/prestacaoc";
            }
            if(numeroPagina){
                url = url+"?page="+numeroPagina;
            }

            if(id){
                this.$http.get(url).then( response => {
                    this.edit_prestacaoc =  response.body;
                });
            }else{
                this.$http.get(url).then( response => {
                    this.prestacaocPaginate = response.body;
                    this.por_pagina = this.prestacaocPaginate.per_page;
                    this.pegaPrestacaoc();
                });
            }

            loader = loader.hide();
        },

        pegaPrestacaoc : function () {
            this.prestacaoc = (this.prestacaocPaginate.data) ? this.prestacaocPaginate.data : this.prestacaocPaginate;
        },

        getPages: function() {
            if (this.limit === -1) { return 0; }
            if (this.limit === 0) { return this.prestacaocPaginate.last_page; }
            var start = this.prestacaocPaginate.current_page - this.limit,
            end   = this.prestacaocPaginate.current_page + this.limit + 1,
            pages = [],
            index;
            start = start < 1 ? 1 : start;
            end   = end >= this.prestacaocPaginate.last_page ? this.prestacaocPaginate.last_page + 1 : end;
            for (index = start; index < end; index++) {
                pages.push(index);
            }
            return pages;
        },

        editar : function(){
            url = this.urlBase + '/prestacaoc';
            this.$http.put(url, {edit_prestacaoc: this.edit_prestacaoc})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.edit_prestacaoc = {};

                    this.getPrestacaoc();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })

        },

        finalizarPrestacaoc : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Finalizar !!!'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/prestacaoc/finalizar/prestacaoc/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getPrestacaoc();
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
                    url = this.urlBase+"/prestacaoc/desativar/prestacaoc/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getPrestacaoc();
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
        this.getPrestacaoc();
        this.getEstados();
        loader = loader.hide();

    }
}
)
</script>
@endsection
