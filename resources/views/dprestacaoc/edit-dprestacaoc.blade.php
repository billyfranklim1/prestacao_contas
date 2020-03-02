<div class="modal fade" id="modalEditPrestacaoc" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel1">Editar Despesa</h4>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="getPessoasByStts(1)">
    			  <span aria-hidden="true">×</span>
    			</button>
    		  </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descricao">Descrição: </label>
                                <input id="descricao" type="text"required="" class="form-control" placeholder="Descrição" v-model="edit_dprestacaoc.descricao" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valor">Valor: </label>
                                <input id="valor" type="number" required="" class="form-control" v-model="edit_dprestacaoc.valor" placeholder="Valor"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="form-group">
                                <label for="">Tipo : </label>
                                <br>
                                <label class="custom-control custom-radio ">
                                    <input type="radio" id="td"  class="custom-control-input " value="1"  v-model="edit_dprestacaoc.tipo" >
                                    <span class="custom-control-indicator"></span> <span class="custom-control-description "> &nbsp; Receita</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input type="radio" id="one" class="custom-control-input " value="0"  v-model="edit_dprestacaoc.tipo">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description "> &nbsp; Despesa</span>
                                </label>
                            </fieldset>
                        </div>
                        <div  class="col-md-6">
                            <div class="form-group">
                                <label for="doc">Categoria: </label>
                                <select id="estado_id" class="form-control custom-select" v-model="edit_dprestacaoc.categoria_id">
                                    <option value="" selected>Selecione a Categoria ...</option>
                                    <option v-for="categoria in categorias" :value="categoria.id">@{{categoria.descricao}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="doc">Documento: </label>
                                <input class="form-control" @change="upload" type="file" name="nome_arquivo"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  v-on:click="getPrestacaoc()" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" v-on:click="editar()">Editar</button>
            </div>
        </div>
    </div>
</div>
