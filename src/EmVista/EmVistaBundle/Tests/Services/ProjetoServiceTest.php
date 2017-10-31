<?php

namespace EmVista\EmVistaBundle\Tests\Services;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;

class ProjetoServiceTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->loadTestFixtures('Domain');
        $this->loadTestFixtures('ProjetoServiceTest');
    }

    /**
     * @test
     */
    public function deveListarCategoriasComSucesso()
    {
        $listaCategorias = $this->get('service.projeto')->listarCategorias();
        $this->assertEquals(15, count($listaCategorias));
    }

    /**
     * @test
     */
    public function deveCadastrarCategoriaComSucesso()
    {
        $sd = ServiceData::build(array('nome' => 'Categoria 3'));
        $categoriaId = $this->get('service.projeto')->salvarCategoria($sd)->getId();
        $categoria = $this->getEntityManager()->find('EmVistaBundle:Categoria', $categoriaId);
        $this->assertEquals('Categoria 3', $categoria->getNome());
    }

    /**
     * @test
     */
    public function deveAlterarCategoriaComSucesso()
    {
        $sd = ServiceData::build(array('id' => 2, 'nome' => 'Categoria 3'));
        $categoriaId = $this->get('service.projeto')->salvarCategoria($sd)->getId();
        $categoria = $this->getEntityManager()->find('EmVistaBundle:Categoria', $categoriaId);
        $this->assertEquals('Categoria 3', $categoria->getNome());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeNomeDaCategoriaForMenorQue2Caracteres()
    {
        $sd = ServiceData::build(array('nome' => 'P'));
        $this->get('service.projeto')->salvarCategoria($sd)->getId();
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeIdDaCategoriaForInvalido()
    {
        $sd = ServiceData::build(array('id' => '1231231asdasd', 'nome' => 'Categoria'));
        $this->get('service.projeto')->salvarCategoria($sd)->getId();
    }

    /**
     * @test
     */
    public function deveAtualizarQuantidadeDeProjetosPublicadosDasCategoriasComSucesso()
    {
        $em = $this->getEntityManager();
        $usuario   = $em->find('EmVistaBundle:Usuario', 1);
        $termoUso  = $em->find('EmVistaBundle:TermoUso', 1);
        $categoria = $em->find('EmVistaBundle:Categoria', 3);

        $projeto = new Projeto();
        $projeto->setUsuario($usuario)
                ->setTermoUso($termoUso)
                ->setPublicado(true)
                ->setCategoria($categoria);

        $projeto2 = new Projeto();
        $projeto2->setUsuario($usuario)
                 ->setTermoUso($termoUso)
                 ->setPublicado(true)
                 ->setCategoria($categoria);

        $projeto3 = new Projeto();
        $projeto3->setUsuario($usuario)
                 ->setTermoUso($termoUso)
                 ->setCategoria($categoria);

        $em->persist($projeto);
        $em->persist($projeto2);
        $em->persist($projeto3);
        $em->flush();

        $this->assertEquals(0, $categoria->getQuantidadeProjetosPublicados());

        $this->get('service.projeto')->atualizarQuantidadeProjetosNasRecompensas();

        $em->refresh($categoria);

        $this->assertEquals(2, $categoria->getQuantidadeProjetosPublicados());
    }
}
