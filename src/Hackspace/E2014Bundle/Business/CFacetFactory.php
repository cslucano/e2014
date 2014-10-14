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

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.nac_pais', 'País de Nac.', 'nac_pais');
        $this->facets['candidato.nac_pais'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.nac_ubigeo', 'Ubigeo de Nac.', 'nac_ubigeo', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
        $this->facets['candidato.nac_ubigeo'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.residencia_ubigeo', 'Ubigeo de Residencia', 'residencia_ubigeo', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
        $this->facets['candidato.residencia_ubigeo'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.residencia_tiempo', 'Tiempo de Residencia', 'residencia_tiempo');
        $this->facets['candidato.residencia_tiempo'] = $cFacet;
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
     * @return array
     */
    public function getCookie()
    {
        $cookie = [];

        /** @var CFacet $cFacet */
        foreach ($this->facets as $cFacet) {
            $cookie[$cFacet->getKeyName()] = 1;
        }

        return $cookie;
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

        if ($cFacet instanceof CFacetORM) {
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
                    $newFacetItem = new CFacetItem($cFacet->getKeyName() . ':' . $term['term'], $cFacet->getShowedFieldValue($entity), $term['count']);
                    $cFacetItems[] = $newFacetItem;
                }
            }

        } elseif ($cFacet instanceof CFacet) {
            foreach ($eFacetValue['terms'] as $term) {
                $newFacetItem = new CFacetItem($cFacet->getKeyName() . ':' . $term['term'], $term['term'], $term['count']);
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
