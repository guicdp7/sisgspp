<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="author" content="Finger Marketing Digital">
        <title>
            <?= $title ?> | SISGSPP
        </title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('style-responsive.css') ?>
        <?= $this->Html->css('global.css') ?>
                
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <?= $this->Html->script('html5shiv.js') ?>
        <?= $this->Html->script('respond.min.js') ?>
        <![endif]-->

        <?php if (count($styles)) : echo $this->Layout->getStyles($styles); endif; ?>
        <?= $this->fetch('meta') ?>
    </head>
<body class="sticky-header">
    <!-- left side start-->
    <div class="left-side sticky-left-side">
        <div class="logo text-center">
            <a href="<?= $this->Layout->getLink('') ?>"><img src="/images/logo2.png" alt="Tecnoportas"></a>
        </div>

        <div class="logo-icon text-center">
            <a href="<?= $this->Layout->getLink('') ?>"><img src="/images/logo1.png" alt="Tecnoportas"></a>
        </div>
        <div class="left-side-inner">
            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="<?= $thisUser[0]['login'] ?>" src="/images/b_user_ico.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#"><?= $thisUser[0]['login'] ?></a></h4>
                    </div>
                </div>

                <h5 class="left-nav-title">Minha Conta</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                    <li><a href="#"><i class="fa fa-user"></i> <span>Perfil</span></a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> <span>Ajustes</span></a></li>
                    <li><a href="<?= $this->Layout->getLink('logout') ?>"><i class="fa fa-sign-out"></i> <span>Sair</span></a></li>
                </ul>
            </div>
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="menu-list<?= $this->Layout->isActive('clientes', $ref) ?>">
                    <a href="#"><i class="fa fa-users"></i> <span>Clientes</span></a>
                    <ul class="sub-menu-list">
                        <li<?= $this->Layout->isActive('novo cliente', $ref, true) ?>><a href="<?= $this->Layout->getLink('clientes/novo') ?>"> + Novo</a></li>
                        <li<?= $this->Layout->isActive('lista de clientes', $ref, true) ?>><a href="<?= $this->Layout->getLink('clientes') ?>">Clientes</a></li>
                    </ul>
                </li>
                <li class="menu-list<?= $this->Layout->isActive('projetos', $ref) ?>">
                    <a href="#"><i class="fa fa-gears"></i> <span>Projetos</span></a>
                    <ul class="sub-menu-list">
                        <li<?= $this->Layout->isActive('novo projeto', $ref, true) ?>><a href="<?= $this->Layout->getLink('projetos/novo') ?>"> + Novo</a></li>
                        <li<?= $this->Layout->isActive('lista de projetos', $ref, true) ?>><a href="<?= $this->Layout->getLink('projetos') ?>">Projetos</a></li>
                    </ul>
                </li>
                <li class="menu-list<?= $this->Layout->isActive('tarefas', $ref) ?>">
                    <a href="#"><i class="fa fa-square"></i> <span>Tarefas</span></a>
                    <ul class="sub-menu-list">
                        <li<?= $this->Layout->isActive('nova tarefa', $ref, true) ?>><a href="<?= $this->Layout->getLink('tarefas/nova') ?>"> + Nova</a></li>
                        <li<?= $this->Layout->isActive('lista de tarefas', $ref, true) ?>><a href="<?= $this->Layout->getLink('tarefas') ?>">Tarefas</a></li>
                        <li<?= $this->Layout->isActive('tipos de tarefas', $ref, true) ?>><a href="<?= $this->Layout->getLink('tarefas/tipos') ?>">Tipos de Tarefas</a></li>
                    </ul>
                </li>
                <li class="menu-list<?= $this->Layout->isActive('usuarios', $ref) ?>">
                    <a href="#"><i class="fa fa-user-md"></i> <span>Usuarios</span></a>
                    <ul class="sub-menu-list">
                        <li<?= $this->Layout->isActive('novo usuario', $ref, true) ?>><a href="<?= $this->Layout->getLink('usuarios/novo') ?>"> + Novo</a></li>
                        <li<?= $this->Layout->isActive('lista de usuarios', $ref, true) ?>><a href="<?= $this->Layout->getLink('usuarios') ?>">Usuarios</a></li>
                    </ul>
                </li>
            </ul>
            <!--sidebar nav end-->
        </div>
    </div>
    <!-- left side end-->
    <!-- main content start-->
    <div class="main-content" >
        <div class="header-section">
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="/images/user_ico.png" alt="<?= $thisUser[0]['login'] ?>" />
                            <?= $thisUser[0]['login'] ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="#"><i class="fa fa-user"></i>  Perfil</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>  Ajustes</a></li>
                            <li><a href="<?= $this->Layout->getLink('logout') ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--notification menu end -->
        </div>
        <div class="page-heading">
            <h3><?= $title ?></h3>
            <ul class="breadcrumb">
                <li><a href="<?= $this->Layout->getLink('') ?>">In&iacute;cio</a></li>
                <li><?= $this->Layout->isLink($this->Layout->getLink($ref[0]), $ref[0]) ?></li>
                <?php if (isset($ref[1])) : ?>
                <li><?= $ref[1] ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="wrapper">
            <?php if (isset($errors)){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i>
                        </button>
                        <?php foreach($errors as $error) { echo $error."<br/>"; } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?= $this->fetch('content') ?>
        </div>
        <footer>
            2018 &copy; Tecnoportas
        </footer>
    </div>
    <?= $this->Html->script('jquery-1.10.2.min.js') ?>
    <?= $this->Html->script('jquery-ui-1.9.2.custom.min.js') ?>
    <?= $this->Html->script('jquery-migrate-1.2.1.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('modernizr.min.js') ?>
    <?= $this->Html->script('jquery.nicescroll.js') ?>
    <?= $this->Html->script('scripts.js') ?>
    <?= $this->Html->script('script.js') ?>
    <?php if (count($scripts)) : echo $this->Layout->getScripts($scripts); endif; ?>
</body>
</html>
