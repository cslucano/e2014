<?php

namespace Hackspace\E2014Bundle\Business;

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
        $candidatos = $this->finder->find($basicQuery->getQuery());

        return $candidatos;
    }
}
