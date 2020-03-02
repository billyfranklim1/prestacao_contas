<div class="modal fade" id="modalFilial" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel1">Nova Prestação de Contas</h4>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="getPessoasByStts(1)">
    			  <span aria-hidden="true">×</span>
    			</button>
    		  </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descricao">Descrição: </label>
                                <input id="descricao" type="text"required="" class="form-control" placeholder="Descrição" v-model="nova_prestacaoc.descricao" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dt_ini">Data Inicio: </label>
                                <input id="dt_ini" type="date" required="" class="form-control" v-model="nova_prestacaoc.dt_ini" placeholder="Data Inicio"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dt_fim">Data Fim: </label>
                                <input id="dt_fim" type="date" required="" class="form-control" v-model="nova_prestacaoc.dt_fim" placeholder="Data Inicio"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  v-on:click="getFiliais()" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" v-on:click="cadastrar()">Salvar</button>
            </div>
        </div>
    </div>
</div>
