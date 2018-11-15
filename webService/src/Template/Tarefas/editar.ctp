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
                            <label class="col-sm-2 control-label m-t m-bot15" for='tbProj'>Projeto:</label>
                            <div class="col-sm-10 m-bot15">
                                <input id="tbProj" class="form-control" type="text" value="<?= $tarefa["projeto"]["nome"] ?>" readonly/>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for='tbTarefa'>Tipo de Tarefa:</label>
                            <div class="col-sm-10 m-bot15">
                                <input id="tbTarefa" class="form-control" type="text" value="<?= $tarefa["tipo"]["nome"] ?>" readonly/>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for='seStatus'>Status:</label>
                            <div class="col-sm-10 m-bot15">
                                <select id='seStatus' class="form-control" name='tarefa[status]'><?php $st = $tarefa["status"]; $sl = " selected='selected'"; ?>
                                    <option value="0"<?= $st == 0 ? $sl : "" ?>>Cancelada</option>
                                    <option value="1"<?= $st == 1 ? $sl : "" ?>>Pendente</option>
                                    <option value="2"<?= $st == 2 ? $sl : "" ?>>Em Desenvolvimento</option>
                                    <option value="3"<?= $st == 3 ? $sl : "" ?>>Concluida</option>
                                </select>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbDesc">Descrição *</label>
                            <div class="col-sm-10 m-bot15">
                                <textarea name="tarefa[descricao]" id="tbDesc" class="form-control" required><?= $tarefa["descricao"] ?></textarea>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbOcorr">Ocorrências</label>
                            <div class="col-sm-10 m-bot15">
                                <textarea name="tarefa[ocorrencias]" id="tbOcorr" class="form-control"><?= $tarefa["ocorrencias"] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("tarefas") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>