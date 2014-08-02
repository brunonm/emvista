<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\StatusDoacao;
use EmVista\EmVistaBundle\Entity\StatusProjeto;

/**
 * SubmissaoRepository
 */
class SubmissaoRepository extends EntityRepository{

    /**
     * @param Usuario $usuario
     * @return Submissao[]
     */
    public function listarSubmissoesPorUsuario($usuario){
        $qb = $this->createQueryBuilder('s')
                   ->join('s.projeto', 'p')
                   ->where('p.usuario = :usuario')
                   ->setParameter('usuario', $usuario->getId(), Type::INTEGER)
                   ->orderBy('s.dataEnvio', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
}