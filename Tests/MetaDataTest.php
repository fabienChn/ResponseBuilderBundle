<?php

namespace fabienChn\ResponseBuilderBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use fabienChn\ResponseBuilderBundle\Component\ResponseBuilder;

class MetaDataTest extends TestCase
{
    const TEST_DATA = [
        ['id' => 1, 'name' => 'hi'],
        ['id' => 2, 'name' => 'hi'],
        ['id' => 3, 'name' => 'hi'],
    ];

    /**
     * @test
     */
    public function itWrapsTheDataInANamespaceIfResourceKeyGiven()
    {
        $response = (new ResponseBuilder(TransformerFixture::class))
            ->collection(self::TEST_DATA, 'data')
            ->toArray();

        $expectedResponse = [
            'data' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ]
        ];

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function itReturnsTheResponseWithTheGivenMetaDataInTheRightStructureUsingTheSetters()
    {
        $response = (new ResponseBuilder(TransformerFixture::class))
            ->collection(self::TEST_DATA, 'data')
            ->setCount(2)
            ->setFilters(['hi'])
            ->setLimit(10)
            ->setOffset(2)
            ->toArray();

        $expectedResponse = [
            'data' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
            'meta' => [
                'count' => 2,
                'filters' => ['hi'],
                'limit' => 10,
                'offset' => 2
            ]
        ];

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @test
     */
    public function itReturnsTheResponseWithTheGivenMetaDataInTheRightStructureUsingSetMeta()
    {
        $meta = [
            'count' => 2,
            'filters' => ['hi'],
            'limit' => 10,
            'offset' => 2
        ];

        $response = (new ResponseBuilder(TransformerFixture::class))
            ->collection(self::TEST_DATA, 'data')
            ->setMeta($meta)
            ->toArray();

        $expectedResponse = [
            'data' => [
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ],
            'meta' => $meta
        ];

        $this->assertEquals($expectedResponse, $response);
    }
}
