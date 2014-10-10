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
    protected $es_missing;
    protected $es_total;
    protected $es_other;
    protected $es_results;

    public function __construct($facet_type, $key_name, $facet_name, $field)
    {
        $this->facet_type = $facet_type;
        $this->key_name = $key_name;
        $this->facet_name = $facet_name;
        $this->field = $field;
        $this->es_missing = 0;
        $this->es_total = 0;
        $this->es_other = 0;
        $this->es_results = [];
    }

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

    /**
     * @return integer
     */
    public function getEsMissing()
    {
        return $this->es_missing;
    }

    /**
     * @param integer $es_missing
     *
     * @return $this
     */
    public function setEsMissing($es_missing)
    {
        $this->es_missing = $es_missing;

        return $this;
    }

    /**
     * @return integer
     */
    public function getEsTotal()
    {
        return $this->es_total;
    }

    /**
     * @param integer $es_total
     *
     * @return $this
     */
    public function setEsTotal($es_total)
    {
        $this->es_total = $es_total;

        return $this;
    }

    /**
     * @return integer
     */
    public function getEsOther()
    {
        return $this->es_other;
    }

    /**
     * @param integer $es_other
     *
     * @return $this
     */
    public function setEsOther($es_other)
    {
        $this->es_other = $es_other;

        return $this;
    }



    public function getEsResults()
    {
        return $this->es_results;
    }

    /**
     * @param CFacetItem $result
     *
     * @return $this
     */
    public function addEsResults(CFacetItem $result)
    {
        $this->es_results[] = $result;

        return $this;
    }

    /**
     * @param Query $query
     */
    public function addFacet($query)
    {
        switch ($this->facet_type) {
            case CFacet::TERMS:
                $facet = new Terms($this->facet_name);
                $facet->setField($this->field);
                $query->addFacet($facet);
                break;
        }
    }
}