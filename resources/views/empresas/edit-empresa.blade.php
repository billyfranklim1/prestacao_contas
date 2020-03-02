<div class="modal fade" id="modalEditEmpresa" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel1">Editar Empresa</h4>

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
                                <input id="razao_social" type="text"required="" class="form-control" placeholder="Razão Social" v-model="edit_empresa.razao_social" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome_fantasia">Nome Fantasia: </label>
                                <input id="nome_fantasia" type="email"required="" class="form-control" placeholder="Nome Fantasia" v-model="edit_empresa.nome_fantasia" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cnpj">CNPJ: </label>
                                <input id="cnpj" type="text" required="" class="form-control" v-model="edit_empresa.cnpj" placeholder="CNPJ"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" id="endereco" name="email" class="form-control" v-model="edit_empresa.endereco" placeholder="Endereço" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">Estado: </label>
                                <select id="estado_id" class="form-control custom-select" v-model="edit_empresa.estado_id" @change="getCidade()">
                                    <option value="" selected>Selecione o estado ...</option>
                                    <option v-for="estado in estados" :value="estado.codigo_uf">@{{estado.nome}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cidade">Cidade: </label>
                                <select id="cidade_id" class="form-control custom-select" v-model="edit_empresa.cidade_id">
                                    <option value="" selected>Selecione a Cidade ...</option>
                                    <option v-for="cidade in cidades" :value="cidade.codigo_ibge">@{{cidade.nome}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cep">CEP: </label>
                                <input id="cep" type="text" required="" class="form-control" v-model="edit_empresa.cep" placeholder="CNPJ"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  v-on:click="getEmpresas()" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" v-on:click="editar()">Editar</button>
            </div>
        </div>
    </div>
</div>
