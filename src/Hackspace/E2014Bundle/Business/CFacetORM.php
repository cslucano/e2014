<?php

namespace Hackspace\E2014Bundle\Business;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Hackspace\E2014Bundle\Util\Util;
use ReflectionObject;

class CFacetORM extends CFacet
{
    /** @var  EntityRepository $repository */
    protected $repository;
    protected $searchField;
    protected $searchMethod;
    protected $showedField;

    public function __construct($facet_type, $key_name, $facet_name, $field, EntityRepository $repository, $searchField, $searchMethod, $showedField)
    {
        parent::__construct($facet_type, $key_name, $facet_name, $field);

        $this->repository = $repository;
        $this->searchField = $searchField;
        $this->searchMethod = $searchMethod;
        $this->showedField = $showedField;
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    public function getByKeys(array $keys)
    {
        $hash = [];

        $entities = $this->repository->findBy([$this->searchField => $keys]);


        if ($entities) {
            /** @var Entity $entity */
            foreach ($entities as $entity) {
                $rObj = new ReflectionObject($entity);
                $mObj = $rObj->getMethod($this->searchMethod);
                $dbKey = (string)$mObj->invoke($entity);

                $hash[$dbKey] = $entity;
            }
        }

        return $hash;
    }

    public function getShowedFieldValue($entity)
    {
        return Util::invokeMethod($entity, $this->showedField);
    }
}
