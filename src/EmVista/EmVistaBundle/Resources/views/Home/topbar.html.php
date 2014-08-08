<div class="topbar-inner">
    <div class="container">
        <p class="brand">O que é EmVista e Crowdfunding? <a href="<?php echo $view['router']->generate('home_crowdfunding'); ?>">Saiba mais</a></p>
        <ul class="nav secondary-nav account-menu pull-right">
            <li class="menu-item last-item item-search">
                <form method="post" action="<?php echo $view['router']->generate('projeto_descubra')?>" 
                      realAction="<?php echo $view['router']->generate('projeto_descubra')?>" class="form-search" autocomplete="off">
                    <input type="text" class="input-search" name="input[search]" />
                    <input type="submit" class="hidden-accessible"/>
                </form>
            </li>
            <li class="menu-item first-item item-join">
                <?php if(!$view['security']->isGranted('IS_AUTHENTICATED_FULLY')): ?>
                    <a href="<?php echo $view['router']->generate('usuario_registro') ?>">Criar conta</a>
                <?php endif; ?>
            </li>
            <li class="menu-item item-login">
                <?php if($view['security']->isGranted('IS_AUTHENTICATED_FULLY')): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Eu<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $view['router']->generate('usuario_dados-pessoais') ?>">
                                    <div class="pull-left img-profile">
                                        <img src="<?php echo $user->getImageProfileWebPath()?>" >
                                    </div>
                                    <div class="profile-name">
                                        <b >
                                            <?php echo $user->getNome()?>
                                        </b>

                                    </div>
                                    <div style="font-size:10px;text-align: right">
                                        <small>Minha conta</small>
                                    </div>


                                </a></li>
                            <li class="divider"></li>
                            <?php if($view['security']->isGranted('ROLE_ADMIN')): ?>
                                <li><a href="<?php echo $view['router']->generate('admin_index') ?>">Administração</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $view['router']->generate('logout') ?>">Sair</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <a href="<?php echo $view['router']->generate('usuario_login') ?>">Entrar</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>