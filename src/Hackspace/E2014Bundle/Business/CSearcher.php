<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Query;
use Elastica\Query\Bool;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Hackspace\E2014Bundle\Entity\BasicQuery;
use Pagerfanta\Pagerfanta;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
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
        $response->headers->setCookie(new Cookie($this::SEARCH_COOKIE_KEY, json_encode($this->cFacetFactory->getCookie())));
    }

    public function __construct(TransformedFinder $finder, CFacetFactory $cFacetFactory, RequestStack $requestStack)
    {
        $this->finder = $finder;
        $this->cFacetFactory = $cFacetFactory;
        $this->candidatos = [];
        $this->cookie = json_decode($requestStack->getCurrentRequest()->cookies->get($this::SEARCH_COOKIE_KEY));
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

        $this->cFacetFactory->setToQuery($query);

        return $query;
    }
}
