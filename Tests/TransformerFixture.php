<?php

namespace fabienChn\ResponseBuilderBundle\Tests;

use fabienChn\ResponseBuilderBundle\Component\AbstractTransformer;

class TransformerFixture extends AbstractTransformer
{
    public function transform(array $data): array
    {
        return [
            'id' => $data['id']
        ];
    }
}
