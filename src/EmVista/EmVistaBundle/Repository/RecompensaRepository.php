<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\Recompensa;

/**
 * RecompensaRepository
 */
class RecompensaRepository extends EntityRepository
{
    /**
     * Listas as recompensas de um projeto que não estão presentes no array passado
     * @param  integer[]    $arrIdsNotIn
     * @param  Projeto      $projeto
     * @return Recompensa[]
     */
    public function listarRecompensasNotIn($arrIdsNotIn, $projeto)
    {
        $qb = $this->createQueryBuilder('r')
                   ->where('r.projeto = :projeto')
                   ->setParameter('projeto', $projeto->getId(), Type::INTEGER);

        if (count($arrIdsNotIn) > 0) {
            $qb->andWhere('r.id NOT IN (:ids)')
               ->setParameter('ids', $arrIdsNotIn);
        }

        return $qb->getQuery()->getResult();
    }
}
