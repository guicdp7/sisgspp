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
                                <th>Nome</th>
                                <th class="hidden-phone">E-mail</th>
                                <th>Telefone</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th class="hidden-phone"><a href="<?= $this->Layout->getLink('clientes/novo') ?>">+ Novo</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($clientes)) : foreach ($clientes as $cliente) : $pessoa = $cliente['pessoas'][0]; $email = $cliente['emails'][0]; $telefone = $cliente['telefones'][0]; $endereco = $cliente['enderecos'][0]; ?>
                            <tr>
                                <td><?= $pessoa['nome'] ?></td>
                                <td class="hidden-phone"><?= $email['email'] ?></td>
                                <td><?= "(" . $telefone['ddd'] . ") " . $telefone['numero'] ?></td>
                                <td><?= $endereco['cidade'] . "-" . $endereco['uf'] ?></td>
                                <td><?php 
                                    if ($cliente['status'] == 0) { ?>
                                        <b>Inativo</b> [<a href="#" onclick="if (confirm('Ativar Cliente <?= $pessoa['nome'] ?>?')) { location.href='<?= $this->Layout->getLink('clientes/ativar?id='.$cliente['id']) ?>'; }">Ativar</a>]
                                    <?php }
                                    else{ ?>
                                        <b>Ativo</b> [<a href="#" onclick="if (confirm('Desativar Cliente <?= $pessoa['nome'] ?>?')) { location.href='<?= $this->Layout->getLink('clientes/desativar?id='.$cliente['id']) ?>'; }">Desativar</a>]
                                    <?php } ?></td>
                                <td class="hidden-phone"><a href="<?= $this->Layout->getLink('clientes/editar?id='.$cliente['id']) ?>">Editar</a> <a href="#" onclick="if (confirm('Excluir <?= $pessoa['nome'] ?>?')){ location.href='<?= $this->Layout->getLink('clientes/excluir?id='.$cliente['id']) ?>'; }">Excluir</a></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>