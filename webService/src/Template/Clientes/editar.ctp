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
                                <label><?php $tip = $cliente["pessoas"][0]["tipo"]; $ck = " checked='checked'"; ?>
                                    <input type="radio" class="pessoa-tipo-f" name="pessoa[tipo]" value="F"<?= $tip == "F" ? $ck : "" ?>/>
                                    F&iacute;sica
                                </label>
                                <label>
                                    <input type="radio" class="pessoa-tipo-j" name="pessoa[tipo]" value="J"<?= $tip == "J" ? $ck : "" ?>>
                                    Jur&iacute;dica
                                </label>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15 label-pessoa-nome" for="tbNome"><?= $tip == "F" ? "Nome *" : "Razão Social" ?></label>
                            <div class="col-sm-10 m-bot15"><?php $pessoa = $cliente["pessoas"][0]; ?>
                                <input type="text" name="pessoa[nome]" id="tbNome" class="form-control" value="<?= $pessoa["nome"] ?>"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-snome" for="tbSNome"><?= $tip == "F" ? "Sobrenome" : "Nome Fantasia *" ?></label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="pessoa[sobrenome]" id="tbSNome" class="form-control" value="<?= $pessoa["sobrenome"] ?>"/>
                            </div><?php $empresa = $cliente["empresas"][0]; ?>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-cpf" for="tbDesc"><?= $tip == "F" ? "CPF" : "CNPJ" ?></label>
                            <div class="col-sm-10 col-md-4 m-bot15">
                                <input type="text" name="pessoa[cnpj]" id="tbDesc" class="form-control" value="<?= $empresa["cnpj"] ?>"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15 label-pessoa-rg" for="tbAcre"><?= $tip == "F" ? "RG" : "IE" ?></label>
                            <div class="col-sm-10 col-md-4 m-bot15">
                                <input type="text" name="pessoa[ie]" id="tbAcre" class="form-control" value="<?= $empresa["ie"] ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Dados de Contato</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group"><?php $email = $cliente["emails"][0]; ?>
                            <label class="col-sm-2 control-label m-bot15" for="tbEmail">E-mail *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="email" name="cliente[email]" id="tbEmail" class="form-control" value="<?= $email["email"] ?>" required/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbTel">Telefone</label>
                            <div class="col-sm-10 m-bot15"><?php $telefone = $cliente["telefones"][0]; ?>
                                <input type="tel" name="cliente[telefone]" id="tbTel" data-mask="(99)9999-9999?9" class="form-control" value="<?= $telefone["telFormatado"] ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-titulo">
                            <h4>Endere&ccedil;o</h4>
                        </div>
                    </div>
                    <div class="row"><?php $endereco = $cliente["enderecos"][0] ?>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-bot15" for="tbCep">CEP</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="end[cep]" id="tbCep" data-mask="99999-999" class="form-control" value="<?= $endereco["cep"] ?>"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbEnd">Endere&ccedil;o</label>
                            <div class="col-sm-10 col-md-7 m-bot15">
                                <input type="text" name="end[logradouro]" id="tbEnd" class="form-control" value="<?= $endereco["logradouro"] ?>"/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="tbNum">N&uacute;mero</label>
                            <div class="col-sm-10 col-md-2 m-bot15">
                                <input type="text" name="end[numero]" id="tbNum" class="form-control" value="<?= $endereco["numero"] ?>"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbCompl">Complemento</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="end[complemento]" id="tbCompl" class="form-control" value="<?= $endereco["complemento"] ?>"/>
                            </div>
                            <label class="col-sm-2 control-label m-bot15" for="tbBairro">Bairro</label>
                            <div class="col-sm-10 col-md-3 m-bot15">
                                <input type="text" name="end[bairro]" id="tbBairro" class="form-control" value="<?= $endereco["bairro"] ?>"/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="tbCidade">Cidade *</label>
                            <div class="col-sm-10 col-md-3 m-bot15">
                                <input type="text" name="end[cidade]" id="tbCidade" class="form-control" value="<?= $endereco["cidade"] ?>" required/>
                            </div>
                            <label class="col-sm-2 col-md-1 control-label m-bot15" for="seuf">Estado *</label>
                            <div class="col-sm-10 col-md-2 m-bot15"><?php $uf = $endereco["uf"]; $sl = " selected='selected'"; ?>
                                <select id="seuf" name="end[uf]" class="form-control">
                                    <option value="0">- Escolha -</option>
                                    <option value="AC"<?= $uf == "AC" ? $sl : "" ?>>Acre</option>
                                    <option value="AL"<?= $uf == "AL" ? $sl : "" ?>>Alagoas</option>
                                    <option value="AP"<?= $uf == "AP" ? $sl : "" ?>>Amapá</option>
                                    <option value="AM"<?= $uf == "AM" ? $sl : "" ?>>Amazonas</option>
                                    <option value="BA"<?= $uf == "BA" ? $sl : "" ?>>Bahia</option>
                                    <option value="CE"<?= $uf == "CE" ? $sl : "" ?>>Ceará</option>
                                    <option value="DF"<?= $uf == "DF" ? $sl : "" ?>>Distrito Federal</option>
                                    <option value="ES"<?= $uf == "ES" ? $sl : "" ?>>Espírito Santo</option>
                                    <option value="GO"<?= $uf == "GO" ? $sl : "" ?>>Goiás</option>
                                    <option value="MA"<?= $uf == "MA" ? $sl : "" ?>>Maranhão</option>
                                    <option value="MT"<?= $uf == "MT" ? $sl : "" ?>>Mato Grosso</option>
                                    <option value="MS"<?= $uf == "MS" ? $sl : "" ?>>Mato Grosso do Sul</option>
                                    <option value="MG"<?= $uf == "MG" ? $sl : "" ?>>Minas Gerais</option>
                                    <option value="PA"<?= $uf == "PA" ? $sl : "" ?>>Pará</option>
                                    <option value="PB"<?= $uf == "PB" ? $sl : "" ?>>Paraíba</option>
                                    <option value="PR"<?= $uf == "PR" ? $sl : "" ?>>Paraná</option>
                                    <option value="PE"<?= $uf == "PE" ? $sl : "" ?>>Pernambuco</option>
                                    <option value="PI"<?= $uf == "PI" ? $sl : "" ?>>Piauí</option>
                                    <option value="RJ"<?= $uf == "RJ" ? $sl : "" ?>>Rio de Janeiro</option>
                                    <option value="RN"<?= $uf == "RN" ? $sl : "" ?>>Rio Grande do Norte</option>
                                    <option value="RS"<?= $uf == "RS" ? $sl : "" ?>>Rio Grande do Sul</option>
                                    <option value="RO"<?= $uf == "RO" ? $sl : "" ?>>Rondônia</option>
                                    <option value="RR"<?= $uf == "RR" ? $sl : "" ?>>Roraima</option>
                                    <option value="SC"<?= $uf == "SC" ? $sl : "" ?>>Santa Catarina</option>
                                    <option value="SP"<?= $uf == "SP" ? $sl : "" ?>>São Paulo</option>
                                    <option value="SE"<?= $uf == "SE" ? $sl : "" ?>>Sergipe</option>
                                    <option value="TO"<?= $uf == "TO" ? $sl : "" ?>>Tocantins</option>
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
                                <input type="text" name="cliente[login]" id="tbUsName" class="form-control" value="<?= $cliente["login"] ?>" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("clientes") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>