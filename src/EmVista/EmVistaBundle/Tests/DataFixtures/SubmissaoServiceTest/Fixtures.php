<?php

namespace EmVista\EmVistaBundle\Tests\DataFixtures\SubmissaoServiceTest;

use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Imagem;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Submissao;
use Doctrine\Common\Persistence\ObjectManager;
use EmVista\EmVistaBundle\Entity\ProjetoImagem;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use Doctrine\Common\DataFixtures\FixtureInterface;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;

class Fixtures implements FixtureInterface
{
    /**
     * Depende de Domain Fixtures
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        //insert usuario
        $usuario = new Usuario();
        $usuario->setEmail('usuario@emvista.me')
                ->setNome('Usuario')
                ->setSenha('8845380aa7de937d396c67b1dbd76d35266089d6')
                ->setSalt('p6j6fh0h20gs0g0s4co0osgwokog4g0')
                ->setDataCadastro(new \DateTime('2012-06-19 22:32:08'))
                ->addUserRole($em->getRepository('EmVistaBundle:Role')->findOneBy(array('id' => Role::ROLE_USER)));
        $em->persist($usuario);

        //insert usuario
        $usuario2 = new Usuario();
        $usuario2->setEmail('usuario2@emvista.me')
                 ->setNome('Usuario2')
                 ->setSenha('8845380aa7de937d396c67b1dbd76d35266089d6')
                 ->setSalt('p6j6fh0h20gs0g0s4co0osgwokog4g0')
                 ->setDataCadastro(new \DateTime('2012-06-19 22:32:08'))
                 ->addUserRole($em->getRepository('EmVistaBundle:Role')->findOneBy(array('id' => Role::ROLE_USER)));
        $em->persist($usuario2);

        //insert termo de uso
        $termoUso = $em->getRepository('EmVistaBundle:TermoUso')->findOneBy(array('id' => 1));

        //insert projeto
        $projeto = new Projeto();
        $projeto->setTermoUso($termoUso)
                ->setUsuario($usuario);
        $em->persist($projeto);

        //insert projeto 2
        $projetoSemUpload = new Projeto();
        $projetoSemUpload->setTermoUso($termoUso)
                ->setUsuario($usuario);
        $em->persist($projetoSemUpload);

        //insert projeto 3
        $projetoEnviado = new Projeto();
        $projetoEnviado->setTermoUso($termoUso)
                       ->setUsuario($usuario)
                       ->setQuantidadeDias(30);
        $em->persist($projetoEnviado);

        //insert imagem
        $imagem = new Imagem();
        $imagem->setUsuario($usuario)
               ->setOriginalFilename('robo')
               ->setExtensao('jpg')
               ->setAltura(470)
               ->setLargura(470)
               ->setSize(36906);
        $em->persist($imagem);

        $tipoProjetoImagem = $em->getRepository('EmVistaBundle:TipoProjetoImagem')
                                ->findOneBy(array('id' => TipoProjetoImagem::TIPO_ORIGINAL));

        //insert projeto imagem
        $projetoImagem = new ProjetoImagem();
        $projetoImagem->setImagem($imagem)
                      ->setProjeto($projeto)
                      ->setTipoProjetoImagem($tipoProjetoImagem);
        $em->persist($projetoImagem);

        $statusSubmissao = $em->getRepository('EmVistaBundle:StatusSubmissao')
                              ->findOneBy(array('id' => StatusSubmissao::STATUS_INICIAL));

        $statusSubmissaoAgAprovacao = $em->getRepository('EmVistaBundle:StatusSubmissao')
                                         ->findOneBy(array('id' => StatusSubmissao::STATUS_AGUARDANDO_APROVACAO));

        // insert submissao
        $submissao = new Submissao();
        $submissao->setProjeto($projeto)
                  ->setStatus($statusSubmissao);
        $em->persist($submissao);

        // insert submissao 2
        $submissao = new Submissao();
        $submissao->setProjeto($projetoSemUpload)
                  ->setStatus($statusSubmissao);
        $em->persist($submissao);

        // insert submissao 3
        $submissao3 = new Submissao();
        $submissao3->setProjeto($projetoEnviado)
                   ->setStatus($statusSubmissaoAgAprovacao)
                   ->setDataEnvio(new \DateTime('now'));
        $em->persist($submissao3);

        $em->flush();
    }
}
