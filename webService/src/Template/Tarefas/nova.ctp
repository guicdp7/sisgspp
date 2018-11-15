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
                            <h4>Dados da Tarefa</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-t m-bot15" for='seProjeto'>Projeto:</label>
                            <div class="col-sm-10 m-bot15">
                                <select id='seProjeto' class="form-control" name='tarefa[projeto_id]'>
                                    <?php if (count($projetos)) : foreach($projetos as $projeto) : ?>
                                    <option value="<?= $projeto["id"] ?>"><?= $projeto["nome"] ?></option>
                                    <?php endforeach; else: ?>
                                    <option value='0'>Nenhum Projeto Cadastrado</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for='seProjeto'>Tipo de Tarefa:</label>
                            <div class="col-sm-10 m-bot15">
                                <select id='seProjeto' class="form-control" name='tarefa[tipo_id]'>
                                    <?php if (count($tipos)) : foreach($tipos as $tipo) : ?>
                                    <option value="<?= $tipo["id"] ?>"><?= $tipo["nome"] ?></option>
                                    <?php endforeach; else: ?>
                                    <option value='0'>Nenhum Tipo de Tarefa Cadastrado</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbDesc">Descrição *</label>
                            <div class="col-sm-10 m-bot15">
                                <textarea name="tarefa[descricao]" id="tbDesc" class="form-control" required></textarea>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbOcorr">Ocorrências *</label>
                            <div class="col-sm-10 m-bot15">
                                <textarea name="tarefa[ocorrencias]" id="tbOcorr" class="form-control"></textarea>
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