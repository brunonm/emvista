<nav class="navbar navbar-custom navbar-fixed-top navbar-color" role="navigation">
    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $view['router']->generate('home_index') ?>">
                <img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/logomarca-culturacf.png')?>" alt="Cultura Crowdfunding" />
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="<?php echo $view['router']->generate('home_index') ?>">home</a></li>
                <li><a href="<?php echo $view['router']->generate('home_crowdfunding-festival') ?>">Crowdfunding Festival</a></li>
                <?php
                if($view['security']->isGranted('IS_AUTHENTICATED_FULLY')): ?>
                    <li class="invert image-profile-content">
                        <a href="#entrar" data-toggle="dropdown">
                            <?php echo $user->getNome()?>&nbsp;<img src="<?php echo $user->getImageProfileWebPath()?>" class="img-circle profile-image" >
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $view['router']->generate('usuario_dados-pessoais') ?>">Minha conta</a></li>
                            <li class="divider"></li>
                            <?php if($view['security']->isGranted('ROLE_ADMIN')): ?>
                                <li><a href="<?php echo $view['router']->generate('admin_index') ?>">Administração</a></li>
                                <li class="divider"></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $view['router']->generate('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php
                else:
                    ?>
                    <li class="invert"><a href="<?php echo $view['router']->generate('usuario_login') ?>">Entrar</a></li>
                <?php
                endif;
                ?>
            </ul>
        </div>

    </div>
</nav>
