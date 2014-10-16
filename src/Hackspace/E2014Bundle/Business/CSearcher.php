<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Filter\BoolAnd;
use Elastica\Filter\BoolOr;
use Elastica\Filter\Missing;
use Elastica\Filter\Term;
use Elastica\Query;
use Elastica\Query\Bool;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Hackspace\E2014Bundle\Entity\BasicQuery;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class CSearcher
{
    const SEARCH_COOKIE_KEY = 'search-modifier-cookie';
    /** @var  TransformedFinder $finder */
    protected $finder;
    protected $cFacetFactory;
    protected $candidatos;
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
        return $this->cFacetFactory->getFacets();
    }

    public function setSearchCookie(Response $response)
    {
        $response->headers->setCookie(new Cookie($this::SEARCH_COOKIE_KEY, json_encode($this->cFacetFactory->getCookie($this->cookie))));
    }

    public function __construct(TransformedFinder $finder, CFacetFactory $cFacetFactory, RequestStack $requestStack)
    {
        $this->finder = $finder;
        $this->cFacetFactory = $cFacetFactory;
        $this->candidatos = [];
        $this->cookie = json_decode($requestStack->getCurrentRequest()->cookies->get($this::SEARCH_COOKIE_KEY), true);
    }

    /**
     * @param BasicQuery $basicQuery
     * @param integer    $page
     * @param integer    $limit
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
        $this->cFacetFactory->populateEsFacetResults($eFacets);

        $this->candidatos = $candidatos;
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

        $this->setFilters($query);

        $this->cFacetFactory->setToQuery($query);

        return $query;
    }

    public function setFilters(Query $query)
    {
        $filters = [];

        foreach ($this->cookie as $cookieKey => $cookieValue)
        {
            if ($cookieValue) {
                $pos = strpos($cookieKey,':');
                $facetKey = substr($cookieKey, 0, $pos);
                $facetTerm = substr($cookieKey, $pos+1);
                //ladybug_dump($facetKey.':'.$facetTerm);
                /** @var CFacet $cFacet */
                $cFacet = $this->cFacetFactory->getFacet($facetKey);
                if ($cFacet) {
                    $filter = new Term();
                    $filter->setTerm($cFacet->getField(), $facetTerm);

                    $filters[$cFacet->getField()][] = $filter;
                }
            }

        }

        if (count($filters) > 0 ) {
            $boolAnd = new BoolAnd();
            foreach ($filters as $keyFacetFilter => $facetFilter) {
                $boolOr = new BoolOr();
                foreach ($facetFilter as $termFilter) {
                    $boolOr->addFilter($termFilter);
                }
                /** @var Missing $missingFilter */
                $missingFilter = new Missing($keyFacetFilter);

                $boolOr->addFilter($missingFilter);

                $boolAnd->addFilter($boolOr);
            }


            $query->setFilter($boolAnd);
        }
    }
}
