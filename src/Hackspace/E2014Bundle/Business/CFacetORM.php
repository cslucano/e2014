<?php

namespace Hackspace\E2014Bundle\Business;

class CFacetORM extends CFacet
{
    protected $repository;
    protected $searchBy;
    protected $nameField;
    protected $resultKeys;

    public function setResultKeys($resultKeys)
    {
        $this->resultKeys = $resultKeys;
    }

    public function setResults($results)
    {
        parent::setResults($results);

    }


    public function __construct($facet_type, $key_name, $facet_name, $field, $repository, $searchBy, $nameField)
    {
        parent::__construct($facet_type, $key_name, $facet_name, $field);

        $this->repository = $repository;
        $this->searchBy = $searchBy;
        $this->nameField = $nameField;
    }
}
