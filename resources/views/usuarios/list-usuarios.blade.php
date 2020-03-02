@extends("layout.template")
@section("conteudo")


<div id="usuario">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Usuarios</h3>
            <div class="row breadcrumbs-top container">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="\">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Usuarios</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <div class="custom-control custom-radio custom-control-inline">
                        <!-- <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modalUsuario" data-toggle="tooltip" data-placement="top" title="Nova Usuario">Nova Usuario</button> -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-header">
            <h4 class="card-title">Lista de Usuarios</h4>
        </div>
        <div class="card-body collapse in">
            <div class="table-responsive card-block">

                <table class="table table-hover table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Empresa</th>
                            <th>Filial</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuario in usuarioPaginate.data">
                            <td class="vertical-align-middle " >@{{usuario.id}}</td>
                            <td class="vertical-align-middle " >@{{usuario.usuario}}</td>
                            <td v-if="usuario.has_empresa.nome_fantasia" class="vertical-align-middle " >@{{usuario.has_empresa.nome_fantasia}}</td>
                            <td v-else class="vertical-align-middle " > --- </td>

                            <td v-if="usuario.has_filial" class="vertical-align-middle " >@{{usuario.has_filial.nome_fantasia}}</td>
                            <td v-else class="vertical-align-middle " > --- </td>

                            <td class="text-center vertical-align-middle "  v-if="usuario.status == 1"><span class="tag tag-success tag-sm"><strong>Ativo</strong></span></td>
                            <td class="text-center vertical-align-middle "  v-if="usuario.status == 0"><span class="tag tag-danger tag-sm"><strong>Inativo</strong></span></td>

                            <td class="text-center vertical-align-middle ">
                                <button v-if="usuario.status == 1" type="button" class="btn btn-tn btn-danger has-tooltip" v-on:click="desativaUsuario(usuario.id)"  data-toggle="tooltip" data-placement="top" title="Desativar Usuario"><i class="fa fa-user-times"></i></button>
                                <button v-if="usuario.status == 0" type="button" class="btn btn-tn btn-success has-tooltip" v-on:click="ativarUsuario(usuario.id)" data-toggle="tooltip" data-placement="top" title="Ativar Usuario"><i class="fa fa-user-plus"></i></button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    <div class="text-xs-center mb-3" v-if="usuarioPaginate.data" >
        <nav aria-label="Page navigation" v-if="usuarioPaginate.data.length != 0">
            <ul class="pagination pagination-sm">
                <li class="page-item" v-if="usuarioPaginate.current_page != 1">
                    <a class="page-link" @click="getUsuarios(usuarioPaginate.current_page-1,'')" aria-label="Previous">«</a>
                </li>
                <li class="page-item" v-for="n in getPages()" :class="{'active' : usuarioPaginate.current_page == n}">
                    <a class="page-link" @click="getUsuarios(n,'')">@{{n}}</a>
                </li>
                <li class="page-item" v-if="usuarioPaginate.current_page != usuarioPaginate.last_page">
                    <a class="page-link" @click="getUsuarios(usuarioPaginate.current_page+1,'')" aria-label="Next">»</a>
                </li>
            </ul>
        </nav>
    </div>




    <!-- include('filiais.cad-usuario') -->
    <!-- include('filiais.edit-usuario') -->


</div>




<script src="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3"></script>
<link href="https://cdn.jsdelivr.net/npm/vue-loading-overlay@3/dist/vue-loading.css" rel="stylesheet">

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);
Vue.use(VueLoading);
Vue.component('loading', VueLoading);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#usuario',
    data: {
        urlBase            : "{{url('')}}",
        usuario             : '',
        edit_usuario        : '',
        usuarioPaginate     : '',
        por_pagina         : 10,
        limit              : 5,

    },
    components: {
        Loading: VueLoading
    },
    methods: {

        getUsuarios : function (numeroPagina='',id=''){
            let loader = this.$loading.show({loader: 'dots' });

            if(id){
                url = this.urlBase+"/usuario/"+id;
            }else{
                url = this.urlBase+"/usuario";
            }
            if(numeroPagina){
                url = url+"?page="+numeroPagina;
            }

            if(id){
                this.$http.get(url).then( response => {
                    this.edit_usuario =  response.body;

                });
            }else{
                this.$http.get(url).then( response => {
                    this.usuarioPaginate = response.body;
                    this.por_pagina = this.usuarioPaginate.per_page;
                    this.pegaUsuarios();
                });
            }

            loader = loader.hide();
        },

        pegaUsuarios : function () {
            this.usuario = (this.usuarioPaginate.data) ? this.usuarioPaginate.data : this.usuarioPaginate;
        },

        getPages: function() {
            if (this.limit === -1) { return 0; }
            if (this.limit === 0) { return this.usuarioPaginate.last_page; }
            var start = this.usuarioPaginate.current_page - this.limit,
            end   = this.usuarioPaginate.current_page + this.limit + 1,
            pages = [],
            index;
            start = start < 1 ? 1 : start;
            end   = end >= this.usuarioPaginate.last_page ? this.usuarioPaginate.last_page + 1 : end;
            for (index = start; index < end; index++) {
                pages.push(index);
            }
            return pages;
        },

        editar : function(){
            url = this.urlBase + '/usuario';
            this.$http.put(url, {usuario: this.edit_usuario})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    Swal.fire(this.response.msg,'','success');
                    this.getUsuarios();

                }else{
                    Swal.fire(this.response.msg,'','error');
                }
            }).catch((err)=>{
                this.response = err;
            })

        },

        ativarUsuario : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Ativar Usuario !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/usuario/ativar/usuario/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getUsuarios();
                        }else{
                            Swal.fire(response.body.msg,'','error');
                        }

                    });
                }
            })
        },

        desativaUsuario : function(id){
            Swal.fire({
                title: 'Você tem certeza?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Desativar Comerciante !'
            }).then((result) => {
                if (result.value) {
                    url = this.urlBase+"/usuario/desativar/usuario/"+id;
                    this.$http.get(url).then((response) => {
                        if(response.body.stts == 1){
                            Swal.fire(response.body.msg,'','success');
                            this.getUsuarios();
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
        this.getUsuarios();
        loader = loader.hide();

    }
}
)
</script>
@endsection
