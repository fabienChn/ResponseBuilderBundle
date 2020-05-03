<?php

namespace fabienChn\ResponseBuilderBundle\Component;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class DataSerializer
 * @package fabienChn\ResponseBuilderBundle\Component
 */
class DataSerializer extends ArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }
}
