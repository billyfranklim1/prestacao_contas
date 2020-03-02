<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel1">Editar Filial</h4>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="getPessoasByStts(1)">
    			  <span aria-hidden="true">×</span>
    			</button>
    		  </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="razao_social">Razão Social: </label>
                                <input id="razao_social" type="text"required="" class="form-control" placeholder="Razão Social" v-model="edit_filiais.razao_social" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome_fantasia">Nome Fantasia: </label>
                                <input id="nome_fantasia" type="email"required="" class="form-control" placeholder="Nome Fantasia" v-model="edit_filiais.nome_fantasia" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefone">Telefone: </label>
                                <input id="telefone" type="text" required="" v-mask="'(##) ####-####', '(##) #####-####'" class="form-control" v-model="edit_filiais.fone" placeholder="Telefone"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="text" id="email" name="email" class="form-control" v-model="edit_filiais.email" placeholder="E-mail" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Usuario">Usuario: </label>
                                <input id="Usuario" type="text" required=""class="form-control" v-model="edit_filiais.strusuario" placeholder="Usuario"  />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  v-on:click="getFiliais()" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" v-on:click="editar()">Editar</button>
            </div>
        </div>
    </div>
</div>
