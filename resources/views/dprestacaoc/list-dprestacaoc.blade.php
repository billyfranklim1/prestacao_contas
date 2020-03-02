@extends("layout.template")
@section("conteudo")


<div id="dprestacaoc">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h4 class="content-header-title mb-0">Itens</h4>
            <div class="row breadcrumbs-top container">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="/prestacaoc/list/prestacaoc">Prestação de contas</a>
                        </li>
                        <li class="breadcrumb-item active"> Itens</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalFilial" data-toggle="tooltip" data-placement="top" title="Nova Filial">Novo Movimento</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row  ">
        <div class="col-xl-4 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="media cursor-pointer">
                        <div class="media-left bg-primary bg-darken-2 p-2 media-middle">
                            <i class="fa fa-arrow-circle-o-up font-large-2 white"></i>
                        </div>
                        <div class="media-body p-1" >
                            <h1>Receita</h1>
                            <h3 class="qtdEmail">R$ @{{resumo.receita}}</h3>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="media cursor-pointer" >
                        <div class="media-left bg-red bg-darken-2 p-2 media-middle">
                            <i class="fa fa-arrow-circle-o-down font-large-2 white"></i>
                        </div>
                        <div class="media-body p-1" >
                            <h1>Despesas</h1>
                            <h3 class="qtdEmail">R$ @{{resumo.despesa}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="media cursor-pointer" >
                        <div class="media-left bg-success bg-darken-2 p-2 media-middle">
                            <i class="fa fa-money font-large-2 white"></i>
                        </div>
                        <div class="media-body p-1" >
                            <h1>Saldo</h1>
                            <h3 class="qtdEmail">R$ @{{resumo.saldo}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="card ">

        <div class="card-header">
            <h4 class="card-title">01/01/2020 à 01/03/2020</h4>
        </div>
        <div class="card-body collapse in">
            <div class="table-responsive card-block">

                <table class="table table-hover table-striped  ">
                    <thead>
                        <tr>
                            <th> - </th>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Categoria</th>
                            <th>Anexo</th>
                            <th>Tipo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dprestacaoc in dprestacaocPaginate.data">
                            <td class=" btn-group  vertical-align-middle text-center" role="group" aria-label="Basic example" style="left: 25px">
                                <button type="button" class="btn btn-icon btn-tn btn-warning has-tooltip" v-on:click="getPrestacaoc('',dprestacaoc.id)"  data-toggle="modal" data-target="#modalEditPrestacaoc" data-toggle="tooltip" data-placement="top" title="Editar Item "><i class="fa fa-pencil-square-o"></i></button>
                                <button v-if="dprestacaoc.status == 1" type="button" class="btn btn-icon btn-tn btn-danger has-tooltip" v-on:click="deletarItem(dprestacaoc.id)" title="Deletar Item"><i class="fa fa-times"></i></button>
                            </td>
                            <td class="vertical-align-middle " >@{{dprestacaoc.id}}</td>
                            <td class="vertical-align-middle " >@{{dprestacaoc.descricao}}</td>
                            <td class="vertical-align-middle " >R$ @{{dprestacaoc.valor}}</td>
                            <td class="vertical-align-middle " >@{{dprestacaoc.has_categoria.descricao}}</td>

                            <td class="vertical-align-middle " > <a :href="'/storage/documentos_prestacao_contas/'+dprestacaoc.arquivo" download >@{{dprestacaoc.arquivo}} </a> </td>
                            <td class="text-center vertical-align-middle "  v-if="dprestacaoc.tipo == 0"><span class="tag tag-danger tag-sm"><strong>DESPESA</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="dprestacaoc.tipo == 1"><span class="tag tag-success tag-sm"><strong>RECEITA</strong></span></td>


                            <td class="text-center vertical-align-middle "  v-if="dprestacaoc.status == 0"><span class="tag tag-danger tag-sm"><strong>CANCELADO</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="dprestacaoc.status == 1"><span class="tag tag-success tag-sm"><strong>ATIVO</strong></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="text-xs-center mb-3" v-if="dprestacaocPaginate.data" >
        <nav aria-label="Page navigation" v-if="dprestacaocPaginate.data.length != 0">
            <ul class="pagination pagination-sm">
                <li class="page-item" v-if="dprestacaocPaginate.current_page != 1">
                    <a class="page-link" @click="getPrestacaoc(dprestacaocPaginate.current_page-1,'')" aria-label="Previous">«</a>
                </li>
                <li class="page-item" v-for="n in getPages()" :class="{'active' : dprestacaocPaginate.current_page == n}">
                    <a class="page-link" @click="getPrestacaoc(n,'')">@{{n}}</a>
                </li>
                <li class="page-item" v-if="dprestacaocPaginate.current_page != dprestacaocPaginate.last_page">
                    <a class="page-link" @click="getPrestacaoc(dprestacaocPaginate.current_page+1,'')" aria-label="Next">»</a>
                </li>
            </ul>
        </nav>
    </div>




    @include('dprestacaoc.cad-dprestacaoc')
    @include('dprestacaoc.edit-dprestacaoc')


</div>




<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);
Vue.use(VueLoading);
Vue.component('loading', VueLoading);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#dprestacaoc',
    data: {
        urlBase             : "{{url('')}}",
        dprestacaoc         : '',
        dprestacaocPaginate : '',
        por_pagina          : 10,
        limit               : 5,
        nova_dprestacaoc    : {
            tipo :0,
            categoria_id:'',
        },
        edit_dprestacaoc    : {},
        prestacao_conta_id  :'{{$id}}',
        documento           :'',
        response            :'',
        tipo                :0,
        resumo              :'',
        categorias          :'',
    },
    components: {
        Loading: VueLoading
    },
    methods: {
        deletarItem : function (id){
            // Swal.fire({
            //     title: 'Você tem certeza que deseja deletar ?',
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Sim, Deletar !!!'
            // }).then((result) => {
            //     if (result.value) {
            //         url = this.urlBase+"/dprestacaoc/deletar/"+id;
            //         this.$http.get(url).then((response) => {
            //             if(response.body.stts == 1){
            //                 Swal.fire(response.body.msg,'','success');
            //                 this.getPrestacaoc();
            //             }else{
            //                 Swal.fire(response.body.msg,'','error');
            //             }
            //
            //         });
            //     }
            // })
            Swal.fire({
                  title: 'Qual o motivo do cancelamento ?',
                  input: 'text',
                  inputAttributes: {
                    autocapitalize: 'off'
                  },
                  showCancelButton: true,
                  confirmButtonText: 'Enviar',
                  showLoaderOnConfirm: true,
                  preConfirm: (login) => {
                      motivo = "O motico do cancelamento: " + login;
                      // dados ={
                      //     'id': id,
                      //     'obs':dados
                      // }
                      url = this.urlBase+"/dprestacaoc/deletar";
                      this.$http.post(url,{id: id, obs:motivo, status: 0}).then( response => {
                          if(response.body.stts == 1){
                              Swal.fire(response.body.msg,'','success');
                              this.getPrestacaoc();
                          }else{
                              Swal.fire(response.body.msg,'','error');
                          }

                      });
                  },
                  allowOutsideClick: () => !Swal.isLoading()
                })
        },
        upload : function(e) {
            e.preventDefault();
            var files = e.target.files;
            this.documento = files[0];
        },

        getEstados : function (){
            url = this.urlBase+"/estados";
            this.$http.get(url).then( response => {
                this.estados = response.body;
                this.cidade = '';
            });
        },

        getCidade : function (){

            estado = this.nova_dprestacaoc.estado_id;

            url = this.urlBase+"/cidades/"+estado;
            this.$http.get(url).then( response => {
                this.cidades = response.body;
            });

        },

        getCategorias : function (){
            url = this.urlBase+"/categorias";
            this.$http.get(url).then( response => {
                this.categorias = response.body;
            });
        },
        cadastrar : function(){

            url = this.urlBase + '/dprestacaoc';
            let data_doc = new FormData();
            if(this.nova_dprestacaoc.tipo == 0){
                this.nova_dprestacaoc.valor = this.nova_dprestacaoc.valor * (-1);
            }
            data_doc.append('documento',this.documento);
            data_doc.append('nova_dprestacaoc',JSON.stringify(this.nova_dprestacaoc));
            data_doc.append('prestacao_conta_id',this.prestacao_conta_id);

            this.$http.post(url,data_doc,{headers: {'Content-Type': 'multipart/form-data'}}).then( response => {

                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.nova_dprestacaoc = {};
                    this.getPrestacaoc();
                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })


        },

        getPrestacaocByStts : function (id){
            let loader = this.$loading.show({loader: 'dots' });
            url = this.urlBase+"/dprestacaoc/"+id+"/byid";
            this.$http.get(url).then((response) => {
                this.dprestacaocPaginate = response.body;
                this.por_pagina = this.dprestacaocPaginate.per_page;
                this.pegaPrestacaoc();
            });
            loader = loader.hide();
        },

        getPrestacaoc : function (numeroPagina='',id=''){
            let loader = this.$loading.show({loader: 'dots' });

            url = this.urlBase+"/dprestacaoc/"+this.prestacao_conta_id;

            if(numeroPagina){
                url = url+"?page="+numeroPagina;
            }

            if(id){
                url = this.urlBase+"/dprestacaoc/"+id+"/byid";
                this.$http.get(url).then( response => {
                    this.edit_dprestacaoc =  response.body;
                    console.log(response.body);

                });
            }else{
                this.$http.get(url).then( response => {
                    this.resumo = response.body.resumo;
                    this.dprestacaocPaginate = response.body.dados;
                    this.por_pagina = this.dprestacaocPaginate.per_page;
                    this.pegaPrestacaoc();
                });
            }

            loader = loader.hide();
        },

        pegaPrestacaoc : function () {
            this.dprestacaoc = (this.dprestacaocPaginate.data) ? this.dprestacaocPaginate.data : this.dprestacaocPaginate;
        },

        getPages: function() {
            if (this.limit === -1) { return 0; }
            if (this.limit === 0) { return this.dprestacaocPaginate.last_page; }
            var start = this.dprestacaocPaginate.current_page - this.limit,
            end   = this.dprestacaocPaginate.current_page + this.limit + 1,
            pages = [],
            index;
            start = start < 1 ? 1 : start;
            end   = end >= this.dprestacaocPaginate.last_page ? this.dprestacaocPaginate.last_page + 1 : end;
            for (index = start; index < end; index++) {
                pages.push(index);
            }
            return pages;
        },

        editar : function(){

            url = this.urlBase + '/dprestacaoc';
            this.$http.put(url, {edit_dprestacaoc: this.edit_dprestacaoc,prestacao_conta_id : this.prestacao_conta_id})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.edit_dprestacaoc = {};

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
                    url = this.urlBase+"/dprestacaoc/finalizar/dprestacaoc/"+id;
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
                    url = this.urlBase+"/dprestacaoc/desativar/dprestacaoc/"+id;
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
        this.getCategorias();
        loader = loader.hide();


        }

}
)
</script>
@endsection
