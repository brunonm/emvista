<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\StatusDoacao;

/**
 * UsuarioRepository
 */
class UsuarioRepository extends EntityRepository{

    /**
     * Lista todos os usuários que possuem a ROLE_ADMIN
     * @return Usuario[]
     */
    public function listarAdministradores(){
        $qb = $this->createQueryBuilder('u')
                   ->join('u.userRoles', 'r')
                   ->where('r.id = :role')
                   ->andWhere('u.status = :status')
                   ->setParameter('role', Role::ROLE_ADMIN)
                   ->setParameter('status', true);

        return $qb->getQuery()->getResult();
    }

    /**
     * Lista todos os apoiadores de um projeto com pagamento aprovado
     * @param Projeto $projeto
     * @return Usuario[]
     */
    public function listarApoiadoresByProjeto(Projeto $projeto){
        $qb = $this->createQueryBuilder('u')
                   ->select('u')
                   ->distinct()
                   ->join('u.doacoes', 'd')
                   ->join('d.recompensa', 'r')
                   ->where('r.projeto = :projeto')
                   ->setParameter('projeto', $projeto->getId())
                   ->andWhere('d.status = :status')
                   ->setParameter('status', StatusDoacao::APROVADO);

        return $qb->getQuery()->getResult();
    }
}