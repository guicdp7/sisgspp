<?php switch ($a) : 
    case "visualizacao" : ?><div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                <?= $title ?>
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th class="hidden-phone">Prazo (dias)</th>
                                <th><a href="<?= $this->Layout->getLink('tarefas/tipos?a=novo') ?>">+ Novo</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($tipos)) : foreach ($tipos as $tipo) : ?>
                            <tr>
                                <td><?= $tipo["id"] ?></td>
                                <td><?= $tipo['nome'] ?></td>
                                <td><?= $tipo['prazo'] ?></td>
                                <td class="hidden-phone"><a href="<?= $this->Layout->getLink('tarefas/tipos?a=editar&id='.$tipo["id"]) ?>">Editar</a> <a href="#" onclick="if (confirm('Excluir o Tipo de Tarefa <?= $tipo['nome'] ?>?')){ location.href='<?= $this->Layout->getLink('tarefas/tipos?a=excluir&id='.$tipo['id']) ?>'; }">Excluir</a></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><?php break; 
case "novo" : ?>
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
                            <h4>Dados do Tipo de Projeto</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbNome">Nome *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="tipo[nome]" id="tbNome" class="form-control" required/>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbPrazo">Prazo Estimado (Dias) *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="number" name="tipo[prazo]" id="tbPrazo" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("tarefas/tipos") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>
<?php break; 
case "editar" : ?>
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
                            <h4>Dados do Tipo de Projeto</h4>
                        </div>
                    </div>
                    <div class="row"><?php $tipo = $tipos[0]; ?>
                        <div class="col-md-12 form-group">
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbNome">Nome *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="text" name="tipo[nome]" id="tbNome" class="form-control" value="<?= $tipo["nome"] ?>" required/>
                            </div>
                            <label class="col-sm-2 control-label m-t m-bot15" for="tbPrazo">Prazo Estimado (Dias) *</label>
                            <div class="col-sm-10 m-bot15">
                                <input type="number" name="tipo[prazo]" id="tbPrazo" class="form-control" value="<?= $tipo["prazo"] ?>" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="col-sm-12 text-right">
                                <a href="<?= $this->Layout->getLink("tarefas/tipos") ?>"><button type="button" class="btn btn-default">Cancelar</button></a>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
</div>
<?php break; endswitch; ?>