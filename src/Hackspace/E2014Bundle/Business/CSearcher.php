<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Query;
use Elastica\Query\Bool;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Hackspace\E2014Bundle\Entity\BasicQuery;

class CSearcher
{
    /** @var  TransformedFinder $finder */
    public $finder;

    public function __construct(TransformedFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param BasicQuery $basicQuery
     *
     * @return array
     */
    public function getCandidatos($basicQuery)
    {
        $query = $this->getQuery($basicQuery);

        $candidatos = $this->finder->find($query);

        return $candidatos;
    }

    /**
     * @param BasicQuery $basicQuery
     *
     * @return Query
     */
    public function getQuery($basicQuery)
    {
        $boolQuery = new Bool();

        $mainQuery = new Query\QueryString($basicQuery->getQuery());
        $boolQuery->addMust($mainQuery);

        if ( ! empty( $basicQuery->getLocation() ) ) {
            $locationQuery = new Query\QueryString($basicQuery->getLocation());
            $locationQuery->setFields([
                'postula_ubigeo_dep',
                'postula_ubigeo_pro',
                'postula_ubigeo_dis',
            ]);

            $boolQuery->addShould($locationQuery);
        }

        return $boolQuery;
    }
}
