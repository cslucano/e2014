<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Query;
use Elastica\Query\Bool;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Hackspace\E2014Bundle\Entity\BasicQuery;
use Pagerfanta\Pagerfanta;

class CSearcher
{
    /** @var  TransformedFinder $finder */
    protected $finder;
    protected $cFacetFactory;
    protected $candidatos;
    protected $facets;
    protected $facetsResults;
    protected $cookie;

    /**
     * @return array
     */
    public function getCandidatos()
    {
        return $this->candidatos;
    }

    /**
     * @return array
     */
    public function getFacetsResults()
    {
        return $this->facetsResults;
    }

    /**
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }


    public function __construct(TransformedFinder $finder, CFacetFactory $cFacetFactory)
    {
        $this->finder = $finder;
        $this->cFacetFactory = $cFacetFactory;
        $this->candidatos = [];
        $this->facetsResults = [];
        $this->facets = [];
        $this->cookie = json_encode([]);
    }

    /**
     * @param BasicQuery $basicQuery
     * @param integer $page
     * @param integer $limit
     *
     * @return array
     */
    public function searchCandidatos($basicQuery, $page, $limit = 20)
    {
        $query = $this->getQuery($basicQuery);

        /** @var Pagerfanta $candidatos */
        $candidatos = $this->finder->findPaginated($query);
        $candidatos->setMaxPerPage($limit);
        $candidatos->setCurrentPage($page);
        $eFacets = $candidatos->getAdapter()->getFacets();
        $this->populateEsFacetResults($eFacets);

        $this->candidatos = $candidatos;
        $this->facetsResults = $this->cFacetFactory->getFacetsResults($this->facets);
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

        $this->facets = $this->cFacetFactory->getFacets();
        $this->cFacetFactory->setToQuery($query);

        return $query;
    }

    /**
     * @param array $eFacets
     */
    public function populateEsFacetResults(array $eFacets)
    {
        foreach ($eFacets as $eFacetKey => $eFacetValue) {
            if (array_key_exists($eFacetKey, $this->facets)) {
                /** @var CFacet $cFacet */
                $cFacet = $this->facets[$eFacetKey];

                $cFacet
                    ->setEsMissing($eFacetValue['missing'])
                    ->setEsTotal($eFacetValue['total'])
                    ->setEsOther($eFacetValue['other'])
                ;

                foreach ($eFacetValue['terms'] as $term) {
                    $newFacetItem = new CFacetItem($term['term'], $term['count']);
                    $cFacet->addEsResults($newFacetItem);
                }
            }
        }
    }
}
