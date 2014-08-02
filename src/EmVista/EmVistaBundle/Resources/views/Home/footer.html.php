<div class="inner">
    <div class="container">
        <div class="row footer-top-navigation">
            <div class="span2 col">
                <h4>Categorias</h4>
                <ul class="categories footer-categories-menu">
                    <?php $qtdPrimeiraColuna = ceil(count($categorias) / 2); ?>
                    <?php for($i = 0; $i < $qtdPrimeiraColuna; $i++): ?>
                        <li class="category-item">
                            <?php if($categorias[$i]->getQuantidadeProjetosPublicados() > 0): ?>
                                <a href="<?php echo $view['router']->generate('projeto_descubraComSearch',array('search' => 'category:' . $categorias[$i]->getSlug())) ?>">
                                    <?php echo $categorias[$i]->getNome(); ?>
                                </a>
                            <?php else: ?>
                                <?php echo $categorias[$i]->getNome(); ?>
                            <?php endif; ?>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="span2 col">
                <h4>&nbsp;</h4>
                <ul class="categories footer-categories-menu">
                    <?php for($i = $qtdPrimeiraColuna; $i < count($categorias); $i++): ?>
                        <li class="category-item">
                            <?php if($categorias[$i]->getQuantidadeProjetosPublicados() > 0): ?>
                                <a href="<?php echo $view['router']->generate('projeto_descubraComSearch',array('search' => 'category:' . $categorias[$i]->getSlug())) ?>">
                                    <?php echo $categorias[$i]->getNome(); ?>
                                </a>
                            <?php else: ?>
                                <?php echo $categorias[$i]->getNome(); ?>
                            <?php endif; ?>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <div class="span5 col">
                <!--
                <div class="sign-newsletter footer-sign-newsletter">
                    <h4>Assine nossa newsletter</h4>
                    <form method="post" action="./" class="sign-newsletter-form">
                        <input type="text" name="email" value="seu email aqui" />
                        <button type="submit">Ok</button>
                    </form>
                </div>
                -->
                <div class="facebook-widget footer-facebook-widget">
                    <h4>EmVista no Facebook</h4>
                    <div class="fb-like" data-href="http://www.facebook.com/EmVistaMe" data-send="false" data-width="380" data-show-faces="true" data-colorscheme="dark" data-font="tahoma"></div>
                </div>
            </div>
            <div class="span3 col">
                <h4>EmVista nas redes</h4>
                <ul class="social-medias footer-social-medias">
                    <li class="media-item media-type-twitter"><a href="http://twitter.com/EmVistaMe" target="_blank" title="Twitter">Twitter</a></li>
                    <li class="media-item media-type-facebook"><a href="http://www.facebook.com/EmVistaMe" target="_blank" title="Facebook">Facebook</a></li>
                    <li class="media-item media-type-youtube"><a href="http://www.youtube.com/EmVistaMe" target="_blank" title="Youtube">Youtube</a></li>
                </ul>
            </div>
        </div>
        <div class="row footer-navigation">
            <div class="span6 col">
                <nav>
                    <ul class="nav navigation-menu footer-navigation-menu">
                        <li class="menu-item item-ajuda"><a href="<?php echo $view['router']->generate('home_ajuda'); ?>">Ajuda</a></li>
                        <li class="menu-item item-termos"><a href="<?php echo $view['router']->generate('home_termosUso'); ?>">Termos de uso</a></li>
                        <li class="menu-item last-item item-contato"><a href="mailto:contato@emvista.me" target="_blank">Contato</a></li>
                    </ul>
                </nav>
            </div>
            <div class="span6 col">
                <p class="copyright footer-copyright"><?php echo date('Y'); ?> EmVista. Todos os direitos reservados</p>
            </div>
        </div>
    </div>
</div>