<?php

namespace EmVista\EmVistaBundle\Tests\DataFixtures\ProjetoServiceTest;

use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Submissao;
use Doctrine\Common\Persistence\ObjectManager;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Fixtures implements FixtureInterface{

    /**
     * Depende de Domain Fixtures
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em){
        $usuario = new Usuario();
        $usuario->setEmail('usuario@emvista.me')
                ->setNome('Usuario')
                ->setSenha('8845380aa7de937d396c67b1dbd76d35266089d6')
                ->setSalt('p6j6fh0h20gs0g0s4co0osgwokog4g0')
                ->setDataCadastro(new \DateTime('2012-06-19 22:32:08'))
                ->addUserRole($em->getRepository('EmVistaBundle:Role')->findOneBy(array('id' => Role::ROLE_USER)));

        $em->persist($usuario);

        $termoUso = $em->getRepository('EmVistaBundle:TermoUso')->findOneBy(array('id' => 1));

        $projeto = new Projeto();
        $projeto->setTermoUso($termoUso)
                ->setUsuario($usuario);

        $em->persist($projeto);

        $em->flush();
    }
}