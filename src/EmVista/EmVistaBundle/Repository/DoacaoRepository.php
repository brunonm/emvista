<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Entity\StatusDoacao;

class DoacaoRepository extends EntityRepository{

    /**
     * @param integer $projetoId
     * @return Doacao[]
     */
    public function listarDoacoesAprovadasByProjetoId($projetoId){
        $qb = $this->createQueryBuilder('d')
                   ->join('d.recompensa', 'r')
                   ->join('r.projeto', 'p')
                   ->where('p.id = :projetoId')
                   ->andWhere('d.status = :status')
                   ->setParameter('projetoId', $projetoId)
                   ->setParameter('status', StatusDoacao::APROVADO);

        return $qb->getQuery()->getResult();
    }


    /**
     * Retorna a quantidade de doações realizadas
     * @param integer $projetoId
     */
    public function countDoacoesAprovadasByProjetoId($projetoId){
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT COUNT(d.id)
            FROM EmVistaBundle:Doacao d
            JOIN d.recompensa r
            JOIN r.projeto p
            WHERE d.status = :status AND p.id = :id');

        $query->setParameter('status', StatusDoacao::APROVADO)
              ->setParameter('id', $projetoId);

        return $query->getSingleScalarResult();
    }
    

    /**
     * Retorna a quantidade de doações realizadas
     * @param integer $projetoId
     */
    public function countDoacoesAprovadasEEstornadasByProjetoId($projetoId){
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT COUNT(d.id)
            FROM EmVistaBundle:Doacao d
            JOIN d.recompensa r
            JOIN r.projeto p
            WHERE (d.status = :statusAprovado OR d.status = :statusEstornado) AND p.id = :id');

        $query->setParameter('statusAprovado', StatusDoacao::APROVADO)
              ->setParameter('statusEstornado', StatusDoacao::ESTORNADO)
              ->setParameter('id', $projetoId);

        return $query->getSingleScalarResult();
    }


    /**
     * @param Usuario $usuario
     * @param Projeto $projeto
     * @return Doacao[]
     */
    public function listarDoacoesUsuarioProjeto($usuario, $projeto){
        $qb = $this->createQueryBuilder('d')
                   ->join('d.recompensa', 'r')
                   ->join('r.projeto', 'p')
                   ->where('p.id = :projeto')
                   ->andWhere('d.status = :status')
                   ->andWhere('d.usuario = :usuario')
                   ->setParameter('projeto', $projeto->getId())
                   ->setParameter('usuario', $usuario->getId())
                   ->setParameter('status', StatusDoacao::APROVADO);

        return $qb->getQuery()->getResult();
    }
}