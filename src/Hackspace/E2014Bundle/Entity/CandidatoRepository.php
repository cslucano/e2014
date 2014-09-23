<?php

namespace Hackspace\E2014Bundle\Entity;

use Doctrine\ORM\EntityRepository;

class CandidatoRepository extends EntityRepository
{
    public function elasticaPopulateQueryBuilder()
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->addSelect('u')
            ->leftJoin('c.postula_ubigeo_e', 'u')
        ;

        return $qb;
    }
}
