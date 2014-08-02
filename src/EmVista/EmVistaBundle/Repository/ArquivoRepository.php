<?php

namespace EmVista\EmVistaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Arquivo;
/**
 * ArquivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArquivoRepository extends EntityRepository {
    /**
     *
     * @param Usuario $usuario
     * @return Arquivo
     */
    public function getLastByUsuario(Usuario $usuario){
        $em = $this->getEntityManager();
        $arrayArquivo = $em->createQuery('
            SELECT
                a
            FROM
                EmVistaBundle:Arquivo a
                JOIN
                    a.usuario u
            WHERE
                u.id = :userId
            ORDER BY
                a.id desc
        ')->setParameter('userId', $usuario->getId())
                ->setMaxResults(1)->getResult();
        return $arrayArquivo[0];
    }
}