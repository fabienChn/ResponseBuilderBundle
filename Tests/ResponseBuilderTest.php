<?php

namespace fabienChn\ResponseBuilderBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use fabienChn\ResponseBuilderBundle\Component\ResponseBuilder;

class ResponseBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function itReturnsAJsonResponseWhenUsingTheResponseBuilder()
    {
        $response = (new ResponseBuilder(TransformerFixture::class))
            ->item(['id' => 1])
            ->response(200);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * @test
     */
    public function itReturnsTheTransformedDataInsteadOfTheInitiallyGivenArray()
    {
        // the transformer is returning "id" only
        $response = (new ResponseBuilder(TransformerFixture::class))
            ->item(['id' => 1, 'name' => 'hi'])
            ->toArray();

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayNotHasKey('name', $response);
    }

    /**
     * @test
     */
    public function itTransformsACollectionAsWell()
    {
        $testData = [
            ['id' => 1, 'name' => 'hi'],
            ['id' => 2, 'name' => 'hi'],
            ['id' => 3, 'name' => 'hi'],
        ];

        // the transformer is returning "id" only
        $response = (new ResponseBuilder(TransformerFixture::class))
            ->collection($testData)
            ->toArray();

        $expectedArray = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        $this->assertEquals($expectedArray, $response);
    }
}
