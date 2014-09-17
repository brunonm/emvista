<?php

namespace EmVista\EmVistaBundle\Tests\Core\ServiceLayer;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;

class ServiceDataTest extends TestCase
{
    /**
     * @var ServiceData
     */
    private $sd;

    protected function setUp()
    {
        parent::setUp();
        $this->sd = ServiceData::build();
    }

    protected function tearDown()
    {
        $this->sd = ServiceData::build();
        parent::tearDown();
    }

   /**
    * @test
    */
    public function deveCarregarDadosComSucesso()
    {
        $data = array('nome' => 'Bruno', 'idade' => 22);
        $this->sd->load($data);
        $this->assertEquals('Bruno', $this->sd->get('nome'));
        $this->assertEquals('Bruno', $this->sd['nome']);
        $this->assertEquals(22, $this->sd->get('idade'));
        $this->assertEquals(22, $this->sd['idade']);
    }

   /**
    * @test
    */
    public function deveCriarUmaNovaInstancia()
    {
        $sd = ServiceData::build();
        $this->assertInstanceOf('EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData', $sd);
    }

   /**
    * @test
    */
    public function deveCriarUmaNovaInstanciaCarregandoDados()
    {
        $data = array('nome' => 'Leonn', 'idade' => 22);
        $sd = ServiceData::build($data);
        $this->assertInstanceOf('EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData', $sd);
        $this->assertEquals('Leonn', $sd->get('nome'));
        $this->assertEquals('Leonn', $sd['nome']);
        $this->assertEquals(22, $sd->get('idade'));
        $this->assertEquals(22, $sd['idade']);
    }

   /**
    * @test
    */
    public function deveSetarERetornarPropriedadeComSucesso()
    {
        $this->sd->set('teste1', 123);
        $this->sd->set('teste2', 321);
        $this->assertEquals(123, $this->sd->get('teste1'));
        $this->assertEquals(123, $this->sd['teste1']);
        $this->assertEquals(321, $this->sd->get('teste2'));
        $this->assertEquals(321, $this->sd['teste2']);
    }

   /**
    * @test
    */
    public function deveRetornarPropriedadeComSucesso2()
    {
        $this->sd->offsetSet('teste1', 123);
        $this->sd->offsetSet('teste2', 321);
        $this->assertEquals(123, $this->sd->offsetGet('teste1'));
        $this->assertEquals(321, $this->sd->offsetGet('teste2'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarExceptionSePropriedadeNaoExistir()
    {
        $this->sd->offsetGet('propriedadeinexistente');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function deveLancarExceptionSePropriedadeNaoExistir2()
    {
        $this->sd->get('propriedadeinexistente');
    }

    /**
     * @test
     */
    public function deveVerificarPropriedadeComSucesso()
    {
        $this->assertFalse($this->sd->offsetExists('propriedadeinexistente'));
        $this->sd->set('propriedadeinexistente', 'agoraexiste');
        $this->assertTrue($this->sd->offsetExists('propriedadeinexistente'));
    }

    /**
     * @test
     */
    public function deveDestruirPropriedadeComSucesso()
    {
        $this->sd->set('propriedadeinexistente', 'agoraexiste');
        $this->assertTrue($this->sd->offsetExists('propriedadeinexistente'));
        $this->sd->offsetUnset('propriedadeinexistente');
        $this->assertFalse($this->sd->offsetExists('propriedadeinexistente'));
    }

    /**
     * @test
     */
    public function deveRetornarObjetoInteiroComSucesso()
    {
        $this->sd->load(array('nome' => 'bruno', 'idade' => 22));
        $data = $this->sd->get();
        $this->assertArrayHasKey('nome', $data);
        $this->assertArrayHasKey('idade', $data);
        $this->assertEquals('bruno', $data['nome']);
        $this->assertEquals(22, $data['idade']);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceDataException
     */
    public function deveLancarExceptionSeTentarRetornarQuandoAindaNaoTiverCarregado()
    {
        $this->sd->get();
    }

    /**
     * @test
     * @expectedException \ErrorException
     */
    public function deveDarErroSeCarregarAlgumDadoQueNaoSejaArray()
    {
        $this->sd->load('asdasd');
    }

    /**
     * @test
     */
    public function deveSetarUsuarioComSucesso()
    {
        $this->sd->setUser('User Test');
        $this->assertEquals('User Test', $this->sd->get('user'));
    }

    /**
     * @test
     */
    public function deveRetornarUsuarioComSucesso()
    {
        $this->sd->setUser('User Test');
        $this->assertEquals('User Test', $this->sd->getUser());
    }
}
