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
                                <th>Empresa</th>
                                <th>Nome</th>
                                <th class="hidden-phone"><a href="<?= $this->Layout->getLink('projetos/novo') ?>">+ Novo</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($projetos)) : foreach ($projetos as $projeto) : $pessoa = $projeto['pessoas'][0]; ?>
                            <tr>
                                <td><?= $pessoa["tipo"] == "F" ? $pessoa['nome'] . " " . $pessoa['sobrenome'] : $pessoa['nome'] ?></td>
                                <td><?= $projeto['nome'] ?></td>
                                <td class="hidden-phone"><a href="<?= $this->Layout->getLink('projetos/editar?id='.$projeto['id']) ?>">Editar</a> <a href="#" onclick="if (confirm('Excluir o Projeto <?= $projeto['nome'] ?>?')){ location.href='<?= $this->Layout->getLink('projetos/excluir?id='.$projeto['id']) ?>'; }">Excluir</a></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>