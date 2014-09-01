<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Facet\Terms;
use Elastica\Query;
use Elastica\Query\Bool;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Hackspace\E2014Bundle\Entity\BasicQuery;
use Pagerfanta\Pagerfanta;

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
     * @param integer $page
     * @param integer $limit
     *
     * @return array
     */
    public function getCandidatos($basicQuery, $page, $limit = 20)
    {
        $query = $this->getQuery($basicQuery);

        /** @var Pagerfanta $candidatos */
        $candidatos = $this->finder->findPaginated($query);
        $candidatos->setMaxPerPage($limit);
        $candidatos->setCurrentPage($page);

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

        if ( ! empty( $basicQuery->getQuery() ) ) {
            $mainQuery = new Query\QueryString($basicQuery->getQuery());
            $boolQuery->addMust($mainQuery);
        }

        if ( ! empty( $basicQuery->getLocation() ) ) {
            $locationQuery = new Query\QueryString($basicQuery->getLocation());
            $locationQuery->setFields([
                'postula_ubigeo_dep',
                'postula_ubigeo_pro',
                'postula_ubigeo_dis',
            ]);

            $boolQuery->addMust($locationQuery);
        }

        $query = Query::create($boolQuery);

        $cFacetFactory = new CFacetFactory();
        $cFacetFactory->getFacets($query);

        return $query;
    }

    /**
     * @param Query $query
     * @param $facetName
     * @param $facetField
     */
    protected function setFacet($query, $facetName, $facetField)
    {
        $facet = new Terms($facetName);
        $facet->setField($facetField);
        $query->addFacet($facet);
    }
}
