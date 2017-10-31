<?php

namespace EmVista\EmVistaBundle\OAuth;

use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Role;

class Provider implements OAuthAwareUserProviderInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->container->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @param \HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface $response
     * @return Usuario
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $em = $this->getEntityManager();
        
        $resource = $response->getResourceOwner()->getName();
        
        $usuario = $em->getRepository("EmVistaBundle:Usuario")
                      ->findOneby(array($resource . 'Id' => $response->getUsername()));
        
        if (!$usuario instanceof Usuario) {
            
            $role = $em->find('EmVistaBundle:Role', Role::ROLE_USER);
                    
            $setter = 'set' . ucfirst($resource) . 'Id';
            
            $usuario = new Usuario();
            $usuario->$setter($response->getUsername())
                    ->addUserRole($role);
            
            if (null != $response->getEmail()) {
                $usuario->setEmail($response->getEmail());
            }
            
            if (null != $response->getRealName()) {
                $usuario->setNome($response->getRealName());
            }
        }
        
        $em->persist($usuario);
        $em->flush();
        
        return $usuario;
    }
}