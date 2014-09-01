<?php

namespace Hackspace\E2014Bundle\Business;


use Elastica\Query;

class CFacetFactory {
    /**
     * @param Query $query
     *
     * @return array
     */
    public function getFacets($query)
    {
        $facets = [];

        $cFacet = new CFacet(CFacet::TERMS, 'Cargo', 'candidato.cargo_autoridad', 'cargo_autoridad');
        $cFacet->addFacet($query);
        $facets['candidato.cargo_autoridad'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'Region', 'candidato.postula_ubigeo_cod_dep', 'postula_ubigeo_cod_dep');
        $cFacet->addFacet($query);
        $facets['candidato.postula_ubigeo_cod_dep'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'Provincia', 'candidato.postula_ubigeo_cod_pro', 'postula_ubigeo_cod_pro');
        $cFacet->addFacet($query);
        $facets['candidato.postula_ubigeo_cod_pro'] = $cFacet;

        $cFacet = new CFacet(CFacet::TERMS, 'Distrito', 'candidato.postula_ubigeo_cod_dis', 'postula_ubigeo_cod_dis');
        $cFacet->addFacet($query);
        $facets['candidato.postula_ubigeo_cod_dis'] = $cFacet;

        return $facets;
    }

    /**
     * @param array $facets
     *
     * @return string
     */
    public function getCookie($facets)
    {
        $cookie = [];

        /** @var CFacet $cfacet */
        foreach ($facets as $cfacet)
        {
            $cookie[$cfacet->$key_name] = 1;
        }

        return json_encode($cookie);
    }
}