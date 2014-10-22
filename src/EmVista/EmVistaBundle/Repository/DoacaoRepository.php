<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Entity\StatusDoacao;

class DoacaoRepository extends EntityRepository
{
    /**
     * @param  integer  $projetoId
     * @return Doacao[]
     */
    public function listarDoacoesAprovadasByProjetoId($projetoId)
    {
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
    public function countDoacoesAprovadasByProjetoId($projetoId)
    {
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
    public function countDoacoesAprovadasEEstornadasByProjetoId($projetoId)
    {
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
     * @param  Usuario  $usuario
     * @param  Projeto  $projeto
     * @return Doacao[]
     */
    public function listarDoacoesUsuarioProjeto($usuario, $projeto)
    {
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
<<<<<<< HEAD

    public function getDoacoesExpirados()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT d, mf
            FROM EmVistaBundle:Doacao d
            JOIN d.movimentacoesFinanceiras mf
            WHERE d.dataCadastro <= :dataInicial AND d.status not in (:status)');

        $date = new \DateTime();
        $date->sub(new \DateInterval('P3D'));

        $query->setParameter('dataInicial', $date)
            ->setParameter('status', array(StatusDoacao::APROVADO, StatusDoacao::CANCELADO, StatusDoacao::ESTORNADO));
        return $query->getResult();

=======
    
    /**
     * @param integer $projetoId
     * @return Doacao[]
     */
    public function listarDoacoesParaEstorno($projetoId)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->join('d.recompensa', 'r')
           ->join('r.projeto', 'p')
           ->where('d.status = :status')
           ->andWhere('p.id = :projeto' )
           ->setParameter('status', StatusDoacao::APROVADO)
           ->setParameter('projeto', $projetoId)
           ->orderBy('d.dataCadastro');
        
        return $qb->getQuery()->getResult();
>>>>>>> fd6e6106566f1395638bddfdbbe79c36d3325222
    }
}
