<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <div class="row row-comece">
        <div class="col-sm-3">
            <img src="/bundles/emvista/images/comece/1Passo.png"/>
        </div>
        <div class="col-sm-3" >
            <img src="/bundles/emvista/images/comece/2Passo.png"/>
        </div>
        <div class="col-sm-3" >
            <img src="/bundles/emvista/images/comece/3Passo.png"/>
        </div>
        <div class="col-sm-3" >
            <img src="/bundles/emvista/images/comece/4Passo.png"/>
        </div>
    </div>
    <div class="row row-comece"  >
        <div class="col-sm-3">
            <div class="comeceTitulo">SUA<br/>IDEIA</div>
            <div class="comeceBody">
                Você acredita na sua ideia? <br>
                Acha que ela é muito boa? <br>
                Nós somos o start que <br>
                você precisa para tirá-la do papel.

            </div>
        </div>
        <div class="col-sm-3">
            <div class="comeceTitulo">SEU<BR>CADASTRO</div>
            <div class="comeceBody">
                Faça seu cadastro e crie seu
                projeto. Não se esqueça de
                detalhes importantes como
                prazo, recompensas e valores.
            </div>
        </div>
        <div class="col-sm-3">
            <div class="comeceTitulo">SUA<BR>DIVULGAÇÃO</div>
            <div class="comeceBody">
                Você precisa divulgar seu
                projeto. Movimente suas
                redes sociais e peça ajuda
                aos seus amigos.
            </div>
        </div>
        <div class="col-sm-3">
            <div class="comeceTitulo">SUAAAAA ALEGRIAAA</div>
            <div class="comeceBody">
                Pessoas vão gostar da sua
                ideia e vão querer te ajudar.
                Se atingir a meta, o dinheiro
                é seu!
            </div>
        </div>
    </div>

    <div class="row linhaMeio">
        <div class="col-sm-12">
            <a href="<?php echo $view['router']->generate('submissao_termo-uso'); ?>" title="Cadastro o seu projeto" alt="Cadaste o seu projeto" class="btn my-btn btn-special-apoiar btn-lg">
                CADASTRE SEU PROJETO
            </a>
            <p class="lead">Dê agora mesmo o start na sua ideia.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="comeceTitulo faqCabecalho">PERGUNTAS FREQUENTES</div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        É só cadastrar o projeto que ele vai pro ar?
                    </div>
                    <div>
                        Não. Primeiramente, seu projeto será submetido a nossa avaliação. Esta etapa não visa
                        julgar ou qualificar a sua ideia, mas sim filtrar aqueles que se enquadram
                        na proposta de um <strong>Financiamento Coletivo</strong> no Cultura Crowdfunding.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        O que devo fazer para meu projeto ser aprovado?
                    </div>
                    <div>
                        Ter uma ideia criativa, com potencial para agregar coisas positivas na vida das pessoas,
                        cujo a motivação não seja financiar a sua vida. É necessário que exista um objetivo definido, com início, meio e fim. Você
                        também precisará enviar um pequeno video mostrando uma visão geral do seu
                        projeto de <strong>Crowdfunding</strong>.
                    </div>
                </div>
                <div class="col-sm-4 video">
                    <a href="<?php echo $view['router']->generate('home_crowdfunding'); ?>">
                        <img src="/bundles/emvista/images/comece/videoComece.png"/>
                    </a>
                    <div class="comeceBody">
                        <br>
                        <p>Assista nosso vídeo e entenda o que é <strong>Crowdfunding</strong> ou, em português, <strong>Financiamento Coletivo</strong>.</p>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Qualquer um pode apoiar?
                    </div>
                    <div>
                        Sim. Basta o apoiador criar ou utilizar a sua conta
                        Moip e pagar da forma que
                        achar mais conveniente. Não existe custo nenhum para quem apoia.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        O que são as recompensas? Como faço pra definí-las?
                    </div>
                    <div>
                        Dentro do <strong>Crowdfunding</strong>, recompensas são premiações que você precisa dar aos seus apoiadores.
                        São contrapartidas que podem ser simbólicas ou realmente grandiosas, desde um
                        simples agradecimento público a algo realmente valioso. Você define cada uma
                        delas de acordo com o seu projeto, incluindo o seu valor. Use sua
                        criatividade, essa é a principal forma de atrair e cativar seu público.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Recebo 100% do dinheiro arrecadado?
                    </div>
                    <div>
                        Não. O Cultura Crowdfunding desconta uma taxa fixa de 5% para custear a manutenção e
                        administração da plataforma. Também serão descontados os encargos das
                        operações financeiras cobradas pelo Moip.
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Existe algum risco financeiro?
                    </div>
                    <div>
                        Absolutamente não. Essa é mais uma das vantagens do <strong>Crowdfunding</strong>.
                        Se seu projeto for bem sucedido, você ficará feliz e
                        ele será financiado. Mas, se isso não acontecer, todas as
                        contribuições serão devolvidas a cada um dos colaboradores, sem custo algum.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Eu perco a propriedade intelectual do meu projeto?
                    </div>
                    <div>
                        Não. Você é o titular dos direitos de propriedade intelectual de
                        sua criação.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        O que é Moip?
                    </div>
                    <div>
                        É um dos líderes no mercado de pagamentos online no Brasil. Porporciona
                        segurança, flexibilidade, agilidade e comodidade nas movimentações
                        financeiras realizadas pela internet.
                    </div>
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Empresas podem participar?
                    </div>
                    <div>
                        Sim. Pessoas jurídicas em geral podem participar contribuindo e enviando projetos.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Se o meu projeto der certo, em quantos dias recebo meu dinheiro?
                    </div>
                    <div>
                        O dinheiro será repassado ao autor do projeto em até 30 dias. Geralmente o repasse
                        é feito em menos dias.
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="faqTitulo">
                        Ainda tem duvidas?
                    </div>
                    <div>
                         Entre em <a href="<?php echo $view['router']->generate('home_contato'); ?>" target="_blank">contato</a> conosco caso ainda tenha
                         dúvidas a respeito de <strong>Crowdfunding</strong>, do Cultura Crowdfunding ou qualquer outro assunto relacionado.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('css') ?>

    <?php foreach($view['assetic']->stylesheets(
            array(
                '@EmVistaBundle/Resources/public/css/emvista/home/comece.css')) as $url): ?>
        <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
    <?php endforeach; ?>

<?php $view['slots']->stop(); ?>
