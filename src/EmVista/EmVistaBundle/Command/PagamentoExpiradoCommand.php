<?php
namespace EmVista\EmVistaBundle\Command;


use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class PagamentoExpiradoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $date = new \DateTime();
        $this
            ->setName('cultura-crowd:pagamento-expirado')
            ->setDescription('Finaliza pagamentos não confirmados expirados, depois de 72 horas o pagamento é automaticamente finalizado');
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * depois
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->getContainer()->get('service.pagamento')->cancelaDoacoesAbertasExpiradas();

    }
} 