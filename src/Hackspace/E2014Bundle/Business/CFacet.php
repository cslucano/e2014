<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Facet\Terms;
use Elastica\Query;

class CFacet
{
    const TERMS = 'terms';

    protected $facet_type;
    protected $key_name;
    protected $facet_name;
    protected $field;
    protected $results;

    /**
     * @return string
     */
    public function getFacetName()
    {
        return $this->facet_name;
    }

    /**
     * @return string
     */
    public function getFacetType()
    {
        return $this->facet_type;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getKeyName()
    {
        return $this->key_name;
    }

    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    public function __construct($facet_type, $key_name, $facet_name, $field)
    {
        $this->facet_type = $facet_type;
        $this->key_name = $key_name;
        $this->facet_name = $facet_name;
        $this->field = $field;
        $this->results = [];
    }

    /**
     * @param Query $query
     */
    public function addFacet($query)
    {
        switch ($this->facet_type) {
            case 'terms':
                $facet = new Terms($this->facet_name);
                $facet->setField($this->field);
                $query->addFacet($facet);
                break;
        }
    }
}