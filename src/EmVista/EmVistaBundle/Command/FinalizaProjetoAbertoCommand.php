<?php
namespace EmVista\EmVistaBundle\Command;


use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FinalizaProjetoAbertoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $date = new \DateTime();
        $this
            ->setName('cultura-crowd:finaliza-abertos')
            ->setDescription('Finaliza projetos que estão abertos')
            ->addOption('date', 'd', InputOption::VALUE_OPTIONAL, 'Data YYYY-MM-DD, default HOJE', $date->format('Y-m-d'));
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = $input->getOption('date');


        $this->getContainer()->get('service.projeto')->finalizaProjetosAbertosQueFinalizamHoje(
            ServiceData::build(array('date' => $date))
        );

    }
} 