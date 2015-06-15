<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Internal\Hydration\HydrationException;
use Doctrine\ORM\Query;
use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Entity\StatusDoacao;
use EmVista\EmVistaBundle\Entity\StatusArrecadacao;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * ProjetoRepository
 */
class ProjetoRepository extends EntityRepository
{
    /**
     * Lista os projetos que estão quase finalizando
     * @param  integer   $diasAFrente
     * @return Projeto[]
     */
    public function listarProjetosRetaFinal($diasAFrente = 10)
    {
        $date = Date::buildDateInFuture($diasAFrente);

        $qb   = $this->createQueryBuilder('p')
                     ->where('p.dataFim <= :dataFim')
                     ->andWhere('p.status = :status')
                     ->setParameter('dataFim', $date, Type::DATETIME)
                     ->setParameter('status', StatusProjeto::PUBLICADO)
                     ->orderBy('p.dataFim', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Lista os projetos que foram publicados recentemente
     * @param integer
     * @return Projeto[]
     */
    public function listarProjetosNovos($diasAtras = 10)
    {
        $date = Date::buildDateInPast($diasAtras);

        $qb   = $this->createQueryBuilder('p')
                     ->where('p.dataAprovacao >= :dataAprovacao')
                     ->andWhere('p.status = :status')
                     ->setParameter('dataAprovacao', $date, Type::DATETIME)
                     ->setParameter('status', StatusProjeto::PUBLICADO)
                     ->orderBy('p.dataAprovacao', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Lista os projetos concluidos e incompletos
     * @return Projeto[]
     */
    public function listarProjetosFinalizadosSemSucessoNaoEstornados()
    {
        $qb = $this->createQueryBuilder('p')
                   ->where('p.statusArrecadacao = :statusArrecadacao')
                   ->andWhere('p.statusFinanceiro is null')
                   ->setParameter('statusArrecadacao', StatusArrecadacao::STATUS_INSUCESSO);

        return $qb->getQuery()->getResult();
    }

    /**
     * Lista os projetos concluidos e não pagos
     * @return Projeto[]
     */
    public function listarProjetosConcluidosNaoPagos()
    {
        $qb = $this->createQueryBuilder('p')
                   ->where('p.statusArrecadacao = :statusArrecadacao')
                   ->andWhere('p.statusFinanceiro is null')
                   ->setParameter('statusArrecadacao', StatusArrecadacao::STATUS_SUCESSO);

        return $qb->getQuery()->getResult();
    }

    /**
     * Retorna o valor já arrecadado de um projeto
     * @param integer $projetoId
     */
    public function calcularValorArrecadado($projetoId)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT SUM(d.valor)
            FROM EmVistaBundle:Doacao d
            JOIN d.recompensa r
            JOIN r.projeto p
            WHERE d.status = :status AND p.id = :id');

        $query->setParameter('status', StatusDoacao::APROVADO)
              ->setParameter('id', $projetoId);

        return $query->getSingleScalarResult();
    }

    /**
     * Retorna a quantidade de projetos aprovados de uma determinada categoria
     * @param integer $categoriaId
     */
    public function countProjetosAprovadosByCategoriaId($categoriaId)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT COUNT(p.id)
            FROM EmVistaBundle:Projeto p
            WHERE p.status IN(:status) AND p.categoria = :categoriaId');

        $arrayStatus = array(StatusProjeto::CONCLUIDO, StatusProjeto::CONCLUIDO_INCOMPLETO, StatusProjeto::PUBLICADO);

        $query->setParameter('status', $arrayStatus)
              ->setParameter('categoriaId', $categoriaId);

        return $query->getSingleScalarResult();
    }

    /**
     * Realiza busca de projetos
     * @param  string    $text
     * @return Projeto[]
     */
    public function busca($text)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where('p.publicado = :publicado')
           ->andWhere($qb->expr()->like('p.nome', ':text'))
           ->orderBy('p.nome', 'DESC');

        $query = $qb->getQuery()
                    ->setParameter('text', '%' . $text . '%')
                    ->setParameter('publicado', true);

        return $query->getResult();
    }

    /**
     * pesquisa projetos com dt_aprovacao != null, publicado = 0, statusArrecadacao = null
     * @return Projeto[]
     */
    public function listarProjetosAprovadosNaoPublicados()
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where('p.publicado = :publicado')
           ->andWhere($qb->expr()->isNotNull('p.dataAprovacao'))
           ->andWhere($qb->expr()->isNull('p.statusArrecadacao'))
           ->setParameter('publicado', false, Type::BOOLEAN);

        return $qb->getQuery()->getResult();
    }

    /**
     * calcula o valor liquido arrecadado e taxas de um projeto
     * @param  Projeto $projeto
     * @return float
     */
    public function calcularValorLiquidoETaxa(Projeto $projeto)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT SUM(mv.valorLiquido) as valorLiquido, SUM(mv.taxa) as taxa
            FROM EmVistaBundle:MovimentacaoFinanceira mv
            JOIN mv.doacao d
            JOIN d.recompensa r
            JOIN r.projeto p
            WHERE d.status = :statusDoacao AND
                  p.id = :id');

        $query->setParameter('statusDoacao', StatusDoacao::APROVADO)
              ->setParameter('id', $projeto->getId());

        return $query->getSingleResult();
    }

    public function getMore($lastProjectId, $count)
    {

        $qb = $this->createQueryBuilder('p');

        $qb->where('p.publicado = :publicado')
            ->andWhere('p.id < :lastId')
            ->setParameter('publicado', true, Type::BOOLEAN)
            ->setParameter('lastId', $lastProjectId)
            ->setMaxResults($count)
            ->orderBy('p.statusArrecadacao', 'ASC')
            ->addOrderBy('p.id', 'DESC');
        return $qb->getQuery()->getResult();

    }

    public function listaProjetosPublicadosNaoFinalizadosByData(\DateTime $data)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT p,r,d,s
            FROM
              EmVistaBundle:Projeto p
              JOIN p.recompensas r
              JOIN r.doacoes d
              JOIN d.status s
            WHERE p.publicado = :publicado
            AND p.dataFim >= :dataFimInicial
            and p.dataFim < :dataFimFinal
            ');

        $dataFim = new \DateTime($data->format('Y-m-d') . ' + 1 day');
        $query->setParameter('dataFimInicial', $data->format('Y-m-d H:i:s'))
            ->setParameter('dataFimFinal', $dataFim->format('Y-m-d H:i:s'))
            ->setParameter('publicado', true);



        return $query->getResult();
    }

}
