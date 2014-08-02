<?php

namespace EmVista\EmVistaBundle\Tests\DataFixtures\PagamentoServiceTest;

use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Imagem;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Submissao;
use EmVista\EmVistaBundle\Entity\Recompensa;
use Doctrine\Common\Persistence\ObjectManager;
use EmVista\EmVistaBundle\Entity\ProjetoImagem;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use Doctrine\Common\DataFixtures\FixtureInterface;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;

class Fixtures implements FixtureInterface{

    /**
     * Depende de Domain Fixtures
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em){
        //insert usuario
        $usuario = new Usuario();
        $usuario->setEmail('usuario@emvista.me')
                ->setNome('Usuario')
                ->setSenha('8845380aa7de937d396c67b1dbd76d35266089d6')
                ->setSalt('p6j6fh0h20gs0g0s4co0osgwokog4g0')
                ->setDataCadastro(new \DateTime('2012-06-19 22:32:08'))
                ->addUserRole($em->getRepository('EmVistaBundle:Role')->findOneBy(array('id' => Role::ROLE_USER)));
        $em->persist($usuario);

        //insert termo de uso
        $termoUso = $em->getRepository('EmVistaBundle:TermoUso')->findOneBy(array('id' => 1));

        $recompensaAgradecimento = new Recompensa();
        $recompensaAgradecimento->setValorMinimo(10)
                   ->setDescricao('Agradecimento no facebook')
                   ->setTitulo('Muito obrigado');
        $em->persist($recompensaAgradecimento);

        $recompensaPamonha = new Recompensa();
        $recompensaPamonha->setValorMinimo(10)
                   ->setDescricao('Pamonha mordida por mim')
                   ->setTitulo('Pamonha')
                   ->setQuantidadeMaximaApoiadores(1);

        $em->persist($recompensaPamonha);

        //insert projeto
        $projeto = new Projeto();
        $projeto->setTermoUso($termoUso)
                ->setUsuario($usuario)
                ->addRecompensa($recompensaAgradecimento)
                ->addRecompensa($recompensaPamonha);
        $recompensaAgradecimento->setProjeto($projeto);
        $recompensaPamonha->setProjeto($projeto);
;
        $em->persist($projeto);

        $statusSubmissao = $em->getRepository('EmVistaBundle:StatusSubmissao')
                              ->findOneBy(array('id' => StatusSubmissao::STATUS_APROVADO));

        // insert submissao
        $submissao = new Submissao();
        $submissao->setProjeto($projeto)
                  ->setStatus($statusSubmissao);
        $em->persist($submissao);

        $em->flush();
    }
}