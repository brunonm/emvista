<?php

namespace EmVista\EmVistaBundle\Tests;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;

require_once(__DIR__ . "/../../../../app/AppKernel.php");

class TestCase extends \PHPUnit_Framework_TestCase{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \AppKernel
     */
    protected $kernel;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Console\Application;
     */
    protected $application;

    /**
     * metodo executado antes de todos os testes
     */
    protected function setUp(){
        $this->kernel = new \AppKernel("test", true);
        $this->kernel->boot();
        $this->container   = $this->kernel->getContainer();
        $this->application = new Application($this->kernel);
        $this->buildDatabase();
        parent::setUp();
    }

    /**
     * @param string $service
     * @return mixed
     */
    protected function get($service){
        return $this->container->get($service);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager(){
        return $this->container->get('doctrine')->getEntityManager();
    }

    /**
     * constrói o database
     * por os testes rodarem com sqlite em memória, não é necessário fazer o drop antes
     */
    protected function buildDatabase(){
        $command = new CreateSchemaDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:create',
        ));
        $command->run($input, new ConsoleOutput(0));
    }

    /**
     * Carrega as fixtures de teste.
     * Deve ser informado o diretorio respectivo dentro de EmVistaBundle/Tests/DataFixtures/
     * @param string $fixture
     */
    protected function loadTestFixtures($fixture){
        $fixtureDir = __DIR__ . '/DataFixtures';
        $fixture = $fixtureDir . DIRECTORY_SEPARATOR . ucfirst($fixture);
        $command = new LoadDataFixturesDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command'       => 'doctrine:fixtures:load',
            '--fixtures'    => $fixture,
            '--append'      => true
        ));
        $command->run($input, new ConsoleOutput(0));
    }
}