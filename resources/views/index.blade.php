@extends("layout.template")
@section("conteudo")


<div id="home" class="">
    <div class="modal fade" id="modalNovo" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
        			<h4 class="modal-title" id="myModalLabel1">VINCULAR MATRIZ</h4>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="getPessoasByStts(1)">
        			  <span aria-hidden="true">×</span>
        			</button>
        		  </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="razao_social">CNPJ: @{{cnpj}}</label>
                                    <input id="razao_social" type="text"required="" v-mask="'##.###.###/####-##'" class="form-control" placeholder="Razão Social" v-model="cnpj" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="    margin-top: 5px;">
                                    <br>
                                    <button type="button" class="btn btn-success" @click="add()">Add</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ref="close" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" v-on:click="cadastrar()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    {{Session::get('tipo')}}

</div>

<script type="text/javascript">

Vue.use(VueMask.VueMaskPlugin);


Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
var app = new Vue({
    el: '#home',
    data: {
        urlBase            : "{{url('')}}",
        cnpj : '',

    },
    methods: {
        add : function(){
            url = this.urlBase + '/filiais/vincularmatriz';
            this.$http.post(url, {cnpj: this.cnpj})
            .then( response => {
                this.response = response.body;
                if(response.body.stts == 1){
                    this.$refs.close.click();
                    Swal.fire(this.response.msg,'','success');
                }else{
                    Swal.fire(this.response.msg,'','error');
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

@endsection
