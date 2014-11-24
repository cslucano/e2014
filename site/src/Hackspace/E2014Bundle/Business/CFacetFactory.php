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

    public function getFacet($facet)
    {
        if (array_key_exists($facet, $this->facets)) {
            return $this->facets[$facet];
        }

        return null;
    }

    public function __construct(EntityManager $em)
    {
        $this->facets = [];

        $ubigeoRepo = $em->getRepository('Hackspace\E2014Bundle\Entity\Ubigeo');

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.cargo_autoridad', 'Cargo al que postula', 'cargo_autoridad');
        $this->facets['candidato.cargo_autoridad'] = $cFacet;

        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.postula_ubigeo', 'Lugar al que postula', 'postula_ubigeo', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
        $this->facets['candidato.postula_ubigeo'] = $cFacet;

//        $cFacet = new CFacet(CFacet::TERMS, 'candidato.nac_pais', 'País de Nac.', 'nac_pais');
//        $this->facets['candidato.nac_pais'] = $cFacet;
//
//        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.nac_ubigeo', 'Ubigeo de Nac.', 'nac_ubigeo', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
//        $this->facets['candidato.nac_ubigeo'] = $cFacet;
//
//        $cFacet = new CFacetORM(CFacet::TERMS, 'candidato.residencia_ubigeo', 'Ubigeo de Residencia', 'residencia_ubigeo', $ubigeoRepo, 'ubigeo', 'getUbigeo', '__toString');
//        $this->facets['candidato.residencia_ubigeo'] = $cFacet;
//
//        $cFacet = new CFacet(CFacet::TERMS, 'candidato.residencia_tiempo', 'Tiempo de Residencia', 'residencia_tiempo');
//        $this->facets['candidato.residencia_tiempo'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.educacion_superior.nombre_estudio', 'Estudio Superior', 'educacion_superior.nombre_estudio');
        $this->facets['candidato.educacion_superior.nombre_estudio'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.educacion_superior.nombre_centro', 'Centro de Estudio Superior', 'educacion_superior.nombre_centro');
        $this->facets['candidato.educacion_superior.nombre_centro'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'candidato.educacion_superior.nombre_carrera', 'Carrera de Estudio Superior', 'educacion_superior.nombre_carrera');
        $this->facets['candidato.educacion_superior.nombre_carrera'] = $cFacet;

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
     * @param array $cookie
     *
     * @return array
     */
    public function getCookie($cookie)
    {
        $newCookie = [];

        /** @var CFacet $cFacet */
        foreach ($this->facets as $cFacet) {
            /** @var CFacetItem $cFacetItem */
            foreach ($cFacet->getEsResults() as $cFacetItem) {
                if ( array_key_exists($cFacetItem->getKey(), $cookie) ) {
                    $newCookie[$cFacetItem->getKey()] = $cookie[$cFacetItem->getKey()];
                    //$newCookie[$cFacetItem->getKey()] = 0;
                } else {
                    $newCookie[$cFacetItem->getKey()] = 1;
                }
            }
        }

        return $newCookie;
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

            ksort($entities);

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
