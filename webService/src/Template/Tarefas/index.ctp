<div class="row">
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
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Prazo (dias)</th>
                                <th class="hidden-phone"><a href="<?= $this->Layout->getLink('tarefas/nova') ?>">+ Nova</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($tarefas)) : foreach ($tarefas as $tarefa) : $data = date_create($tarefa['dt_cadastro']); ?>
                            <tr><?php $arrayStatus = array("Cancelada", "Pendente", "Em Desenvolvimento", "Concluida"); ?>
                                <td><?= date_format($data, 'd/m/Y') ?><br/><?= date_format($data, 'H:i') ?></td>
                                <td><?= $tarefa['descricao'] ?></td>
                                <td><?= $arrayStatus[$tarefa["status"]] ?></td>
                                <td><?= $tarefa['prazo'] ?></td>
                                <td class="hidden-phone"><a href="<?= $this->Layout->getLink('tarefas/editar?id='.$tarefa['id']) ?>">Editar</a></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>