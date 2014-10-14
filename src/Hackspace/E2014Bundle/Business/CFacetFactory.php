<?php

namespace Hackspace\E2014Bundle\Business;

use Doctrine\ORM\EntityManager;
use Elastica\Query;

class CFacetFactory
{
    protected $facets;

    /**
     * @return array
     */
    public function getFacets()
    {
        return $this->facets;
    }

    public function __construct(EntityManager $em)
    {
        $this->facets = [];

        $ubigeoRepo = $em->getRepository('Hackspace\E2014Bundle\Entity\Ubigeo');

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.cargo_autoridad', 'Cargo', 'cargo_autoridad');
        $this->facets['candidato.cargo_autoridad'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.postula_ubigeo_cod_dep', 'Región', 'postula_ubigeo_cod_dep', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
        $this->facets['candidato.postula_ubigeo_cod_dep'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.postula_ubigeo_cod_pro', 'Provincia', 'postula_ubigeo_cod_pro', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
        $this->facets['candidato.postula_ubigeo_cod_pro'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.postula_ubigeo_cod_dis', 'Distrito', 'postula_ubigeo_cod_dis', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
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
        foreach ($this->facets as $cFacet) {
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
        foreach ($facets as $cFacet) {
            $cookie[$cFacet->getKeyName()] = 1;
        }

        return json_encode($cookie);
    }

    public function getFacetsResults($facets)
    {
        $facetResults = [];
        /** @var CFacet $facet */
        foreach ($facets as $facet) {
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
                    ->setEsOther($eFacetValue['other']);

                $this->populateEsFacetItem($cFacet, $eFacetValue);
            }
        }
    }

    private function populateEsFacetItem($cFacet, $eFacetValue)
    {
        $cFacetItems = [];

        if ($cFacet instanceOf CFacetORM) {
            $hash = [];
            $hashKeys = [];

            foreach ($eFacetValue['terms'] as $term) {
                $hash[$term['term']] = $term;
                $hashKeys[] = $term['term'];
            }

            $entities = $cFacet->getByKeys($hashKeys);

            foreach ($entities as $key => $entity) {
                if (array_key_exists($key, $hash)) {
                    $term = $hash[$key];
                    $newFacetItem = new CFacetItem($term['term'], $cFacet->getShowedFieldValue($entity), $term['count']);
                    $cFacetItems[] = $newFacetItem;
                }
            }

        } else if ($cFacet instanceOf CFacet) {
            foreach ($eFacetValue['terms'] as $term) {
                $newFacetItem = new CFacetItem($term['term'], $term['term'], $term['count']);
                $cFacetItems[] = $newFacetItem;
            }
        }


        array_map(
            function ($item) use ($cFacet) {
                $cFacet->addEsResults($item);
            },
            $cFacetItems
        );
    }
}
