<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="author" content="Guilherme Cristino Diogo de Paula">
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
        
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body class="login-body">
        <div class="container">
            <form class="form-signin" method="POST" action="<?= $this->Layout->getLink('login') ?>">
                <div class="form-signin-heading text-center">
                    <h1 class="sign-title">Acesse sua Conta</h1>
                    <img src="/images/logo2.png" style="width: 60%; display: block; margin: 0 auto;" alt="SISGSPP"/>                    
                </div>
                <div class="login-wrap">
                    <input type="text" class="form-control" placeholder="Identificação" name='username' autofocus/>
                    <input type="password" class="form-control" placeholder="Senha" name='senha'/>

                    <?php if (isset($errors['login'])) : ?>
                    <div class="alert alert-warning">
                        <?= $errors['login'] ?>
                    </div>
                    <?php endif; ?>
                    
                    <button class="btn btn-lg btn-login btn-block" type="submit">
                        <i class="fa fa-check"></i> Entrar
                    </button>
                    <div class="registration">
                        <a data-toggle="modal" href="#myModal">Esqueci minha senha</a>
                    </div>
                </div>                
            </form>
            <form class="form-signin" method="POST" action='<?= $this->Layout->getLink('login') ?>'>
                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Esqueceu sua senha?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Informe seu nome de usuário ou senha para recuperar seu acesso.</p>
                                <input type="text" name="username" placeholder="Identificação" autocomplete="off" class="form-control placeholder-no-fix">

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                <button class="btn btn-primary" type="submit">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
            </form>
        </div>
        
        <?= $this->Html->script('jquery-1.10.2.min.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
        <?= $this->Html->script('modernizr.min.js') ?>   
    </body>
</html>