<?php

namespace Hackspace\E2014Bundle\Business;


use Elastica\Query;

class CFacetFactory {

    protected $facets;

    /**
     * @return array
     */
    public function getFacets()
    {
        return $this->facets;
    }

    public function __construct()
    {
        $this->facets = [];

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.cargo_autoridad', 'Cargo', 'cargo_autoridad');
        $this->facets['candidato.cargo_autoridad'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.postula_ubigeo_cod_dep', 'Región', 'postula_ubigeo_cod_dep');
        $this->facets['candidato.postula_ubigeo_cod_dep'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.postula_ubigeo_cod_pro', 'Provincia', 'postula_ubigeo_cod_pro');
        $this->facets['candidato.postula_ubigeo_cod_pro'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.postula_ubigeo_cod_dis', 'Distrito',  'postula_ubigeo_cod_dis');
        $this->facets['candidato.postula_ubigeo_cod_dis'] = $cFacet;

    }
    /**
     * @param Query $query
     *
     * @return array
     */
    public function setToQuery($query)
    {
        /** @var CFacet $cFacet */
        foreach ($this->facets as $cFacet)
        {
            $cFacet->addFacet($query);
        }
    }

    /**
     * @param array $facets
     *
     * @return string
     */
    public function getCookie($facets)
    {
        $cookie = [];

        /** @var CFacet $cFacet */
        foreach ($facets as $cFacet)
        {
            $cookie[$cFacet->getKeyName()] = 1;
        }

        return json_encode($cookie);
    }

    public function getFacetsResults($facets)
    {
        $facetResults = [];
        /** @var CFacet $facet */
        foreach($facets as $facet)
        {
            $facetResults[$facet->getKeyName()] = $facet;
        }

        return $facetResults;
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