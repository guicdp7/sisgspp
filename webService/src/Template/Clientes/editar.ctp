<div class="row">
    <div class='col-md-12'>
        <form method="POST" enctype="multipart/form-data">
            <section class="panel">
                <header class="panel-heading">
                    <?= $title ?>
                    <span class="tools pull-right">
                        <a class="fa fa-chevron-down" href="javascript:;"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Dados do Cliente</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-2 control-label m-bot15">
                                Pessoa *
                            </div>
                            <div class="col-sm-10 radio m-bot15">
                                <label>
                                    <input type="radio" class="pessoa-tipo-f" name="pessoa[tipo]" value="F" checked="checked"/>
                                    F&iacute;sica
                                </label>
                                <label>
                                    <input type="radio" class="pessoa-tipo-j" name="pessoa[tipo]" value="J">
                                    Jur&iacute;dica
                                </label>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15 label-pessoa-nome" for="tbNome">Nome *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="pessoa[nome]" id="tbNome" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-snome" for="tbSNome">Sobrenome</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="pessoa[sobrenome]" id="tbSNome" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-cpf" for="tbDesc">CPF </label>
                            <div class="col-sm-10 col-md-4 m-bot15">
                                <input type="text" name="pessoa[cnpj]" id="tbDesc" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-rg" for="tbAcre">RG</label>
                            <div class="col-sm-10 col-md-4 m-bot15">
                                <input type="text" name="pessoa[ie]" id="tbAcre" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Dados de Contato</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-bot15" for="tbEmail">E-mail *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="email" name="cliente[email]" id="tbEmail" class="form-control" required/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbTel">Telefone</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="tel" name="cliente[telefone]" id="tbTel" data-mask="(99)9999-9999?9" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Endere&ccedil;o</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-bot15" for="tbCep">CEP</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="end[cep]" id="tbCep" data-mask="99999-999" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbEnd">Endere&ccedil;o</label>
                            <div class="col-sm-10 col-md-7 m-bot15">
                                <input type="text" name="end[logradouro]" id="tbEnd" class="form-control"/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="tbNum">N&uacute;mero</label>
                            <div class="col-sm-10 col-md-2 m-bot15">
                                <input type="text" name="end[numero]" id="tbNum" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbCompl">Complemento</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="end[complemento]" id="tbCompl" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbBairro">Bairro</label>
                            <div class="col-sm-10 col-md-3 m-bot15">
                                <input type="text" name="end[bairro]" id="tbBairro" class="form-control"/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="tbCidade">Cidade *</label>
                            <div class="col-sm-10 col-md-3 m-bot15">
                                <input type="text" name="end[cidade]" id="tbCidade" class="form-control" required/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="seuf">Estado *</label>
                            <div class="col-sm-10 col-md-2 m-bot15">
                                <select id="seuf" name="end[uf]" class="form-control">
                                    <option value="0">- Escolha -</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Dados de Acesso</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-bot15" for="tbUsName">Nome de Usuário *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="cliente[login]" id="tbUsName" class="form-control"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbSenha">Senha *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="cliente[senha]" id="tbSenha" class="form-control" autocomplete="new-password"/>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("tarefas") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>