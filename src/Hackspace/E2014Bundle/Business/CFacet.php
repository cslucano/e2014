<?php

namespace Hackspace\E2014Bundle\Business;

use Elastica\Facet\Terms;
use Elastica\Query;

class CFacet {
    const TERMS = 'terms';

    protected $facet_type;
    protected $key_name;
    protected $facet_name;
    protected $field;

    public function __construct($facet_type, $key_name, $facet_name, $field)
    {
        $this->facet_type = $facet_type;
        $this->key_name = $key_name;
        $this->facet_name = $facet_name;
        $this->field = $field;
    }

    /**
     * @param Query $query
     */
    public function addFacet($query)
    {
        switch($this->facet_type)
        {
            case 'terms':
                $facet = new Terms($this->facet_name);
                $facet->setField($this->field);
                $query->addFacet($facet);
                break;
        }
    }
}