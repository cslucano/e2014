<?php

namespace Hackspace\E2014Bundle\Tests\Business;

use Hackspace\E2014Bundle\Business\CFacet;
use Hackspace\E2014Bundle\Business\CFacetFactory;
use Hackspace\E2014Bundle\Business\CFacetItem;
use Hackspace\E2014Bundle\Tests\Util\Util;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CFacetFactoryTest extends WebTestCase
{
    protected $facetResult = [
        'facet_1' => [
            '_type' => 'terms',
            'missing' => 1,
            'total' => 15,
            'other' => 3,
            'terms' => [
                [
                    'term' => 'term_a',
                    'count' => 10,
                ],
                [
                    'term' => 'term_b',
                    'count' => 5,
                ]
            ]
        ],
        'facet_2' => [
            '_type' => 'terms',
            'missing' => 5,
            'total' => 25,
            'other' => 6,
            'terms' => [
                [
                    'term' => 'term_x',
                    'count' => 10,
                ],
                [
                    'term' => 'term_y',
                    'count' => 15,
                ]
            ]
        ],
    ];

    protected $facets;

    protected function setUp()
    {
        parent::setUp();

        $this->facets = [
            'facet_1' => new CFacet(CFacet::TERMS, 'facet_1', 'Facet 1', 'facet1'),
            'facet_2' => new CFacet(CFacet::TERMS, 'facet_2', 'Facet 2', 'facet2'),
        ];
    }

    public function testPopulateEsFacetResults()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        /** @var CFacetFactory $cFacetFactory */
        $cFacetFactory = $container->get('hackspace_e2014.c_facet_factory');

        Util::setPropertyValue($cFacetFactory, 'facets', $this->facets);

        $cFacetFactory->populateEsFacetResults($this->facetResult);

        $facets = Util::getPropertyValue($cFacetFactory, 'facets');
        $this->assertCount(2, $facets);

        /** @var CFacet $cFacet */
        $cFacet = $facets['facet_1'];
        $esResults = $cFacet->getEsResults();
        $this->assertEquals(1, $cFacet->getEsMissing());
        $this->assertEquals(15, $cFacet->getEsTotal());
        $this->assertEquals(3, $cFacet->getEsOther());
        $this->assertCount(2, $esResults);
        /** @var CFacetItem $esResult */
        $esResult = $esResults[0];
        $this->assertEquals('term_a', $esResult->getTerm());
        $this->assertEquals(10, $esResult->getCount());
        $esResult = $esResults[1];
        $this->assertEquals('term_b', $esResult->getTerm());
        $this->assertEquals(5, $esResult->getCount());

        $cFacet = $facets['facet_2'];
        $esResults = $cFacet->getEsResults();
        $this->assertEquals(5, $cFacet->getEsMissing());
        $this->assertEquals(25, $cFacet->getEsTotal());
        $this->assertEquals(6, $cFacet->getEsOther());
        $esResult = $esResults[0];
        $this->assertEquals('term_x', $esResult->getTerm());
        $this->assertEquals(10, $esResult->getCount());
        $esResult = $esResults[1];
        $this->assertEquals('term_y', $esResult->getTerm());
        $this->assertEquals(15, $esResult->getCount());
    }

}
