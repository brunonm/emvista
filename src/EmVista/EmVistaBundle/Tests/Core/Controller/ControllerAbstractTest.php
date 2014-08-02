<?php

namespace EmVista\EmVistaBundle\Tests\Core\Controller;

use EmVista\EmVistaBundle\Tests\TestCase;

class ControllerAbstractTest extends TestCase{

    /**
     * @var \EmVista\EmVistaBundle\Core\Controller\ControllerAbstract
     */
    private $stubControllerAbstract = null;

    protected function setUp(){
        parent::setUp();

        $this->stubControllerAbstract = $this->getMockForAbstractClass(
                'EmVista\EmVistaBundle\Core\Controller\ControllerAbstract'
        );
    }

    /**
     * @test
     */
    public function deveRetornarUsuarioComSucesso(){
        $this->markTestIncomplete('Falta aprender a setar usuario na sessao durante os testes e inicar o controller');
        $expected = 'EmVista\EmVistaBundle\Entity\Usuario';
        $this->assertInstanceOf($expected, $this->stubControllerAbstract->getUser());
    }

}