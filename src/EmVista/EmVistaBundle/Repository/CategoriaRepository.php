<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Entity\Categoria;

class CategoriaRepository extends EntityRepository
{
    /**
     * Lista as categorias que possuem projetos
     * @return Categoria[]
     */
    public function listarCategoriasComProjetos()
    {
        $qb = $this->createQueryBuilder('p')
                   ->where('p.quantidadeProjetosPublicados > 0')
                   ->orderBy('p.nome', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
