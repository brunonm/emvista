
<footer id="footer">

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-xs-12">

                <ul class="list-inline inline-menu">
                    <li class="logo-content no-after"><img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/logomarca2.png') ?>" alt="Logomarca" /></li>
                    <li><a href="<?php echo $view['router']->generate('home_termos-uso'); ?>">TERMOS DE USO</a></li>
                    <li><a href="<?php echo $view['router']->generate('home_ajuda'); ?>">FAQ</a></li>
                    <li><a href="<?php echo $view['router']->generate('home_contato'); ?>">CONTATO</a></li>
                    <li class="no-after"><a href="<?php echo $view['router']->generate('home_crowdfunding'); ?>">O QUE É CROWDFUNDING?</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-xs-12">
                <ul class="list-inline inline-menu">
                    <li class="logo-fac-content no-after"><img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/logo-fac.png'); ?>" alt="Logomarca" /></li>
                    <li class="logo-fac-content  no-after"><div class="text">REALIZAÇÃO:</div><img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/logo-culturaOff.png'); ?>" alt="Logomarca" style="height: 65px" /></li>
                    <li class=" no-after"><div class="text">DESENVOLVIDO POR:</div><img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/tear-tecnologia-white.png'); ?>" alt="Logomarca" style="width: 135px" /></li>
                </ul>
            </div>

        </div><!-- .row -->

    </div><!-- .container -->

</footer>
