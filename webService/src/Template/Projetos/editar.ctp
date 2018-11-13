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
                            <h4>Dados do Projeto</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-t m-bot15" for='seEmpresa'>Empresa:</label>
                            <div class="col-sm-10 m-bot15">
                                <select id='seEmpresa' class="form-control" name='projeto[empresa_id]'>
                                    <?php if (count($empresas)) : $sl = " selected='selected'"; foreach($empresas as $empresa) : ?>
                                    <option value="<?= $empresa['id'] ?>"<?= $projeto["empresa_id"] == $empresa['id'] ? $sl : "" ?>><?= $empresa['nome'] ?></option>
                                    <?php endforeach; else: ?>
                                    <option value='0'>Nenhuma Empresa Cadastrada</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbNome">Nome *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="projeto[nome]" id="tbNome" class="form-control" value="<?= $projeto["nome"] ?>" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("projetos") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>