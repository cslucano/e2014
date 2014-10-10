<?php

namespace Hackspace\E2014Bundle\Business;

class CFacetItem
{
    protected $term;
    protected $count;

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param string $term
     *
     * @return $this
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * @return string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }
}
