<?php

namespace fabienChn\ResponseBuilderBundle\Component;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ResponseBuilder
 * @package fabienChn\ResponseBuilderBundle\Component
 */
class ResponseBuilder
{
    /**
     * @var \League\Fractal\Manager
     */
    private $fractalManager;

    /**
     * Transformer extending Fractal's TransformerAbstract
     *
     * @var
     */
    private $transformer;

    /**
     * @var \League\Fractal\Resource\ResourceAbstract
     */
    private $resource;

    /**
     * @var array
     */
    private $meta = [];

    /**
     * ResponseBuilder constructor.
     * @param $transformer : Transformer name as string or transformer instance
     */
    public function __construct($transformer)
    {
        $this->fractalManager = new Manager();

        $this->fractalManager->setSerializer(new DataSerializer());

        $transformerInstance = is_string($transformer) ? new $transformer() : $transformer;

        $this->transformer = $transformerInstance;
    }

    /**
     * @param $data
     * @param string|null $resourceKey
     * @return $this
     */
    public function collection($data, string $resourceKey = null): self
    {
        $this->resource = new Collection($data, $this->transformer, $resourceKey);

        return $this;
    }

    /**
     * @param $data
     * @param string|null $resourceKey
     * @return $this
     */
    public function item($data, string $resourceKey = null): self
    {
        $this->resource = new Item($data, $this->transformer, $resourceKey);

        return $this;
    }

    /**
     * @return \League\Fractal\Scope
     */
    private function process(): Scope
    {
        return $this->fractalManager->createData($this->resource);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->process()->toArray();
    }

    /**
     * @param int $status
     * @return JsonResponse
     */
    public function response(int $status = 200): JsonResponse
    {
        $array = $this->process()->toArray();

        return new JsonResponse($array, $status);
    }

    /**
     * @TODO: unit tests
     *
     * @param array $data
     * @return $this
     */
    public function parseIncludes(array $data): self
    {
        $this->fractalManager->parseIncludes($data);

        return $this;
    }

    /**
     * @param array $meta
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function setMeta(array $meta): self
    {
        if (! $this->resource instanceof Collection) {
            throw new \Exception('You can only set meta data to a Collection Resource.');
        }

        $this->meta = $meta;

        $this->resource->setMeta($this->meta);

        return $this;
    }

    /**
     * @param array $meta
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function addMeta(array $meta): self
    {
        return $this->setMeta(array_merge($this->meta, $meta));
    }

    /**
     * @param int $count
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function setCount(int $count): self
    {
        return $this->addMeta(['count' => $count]);
    }

    /**
     * @param int $offset
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function setOffset(int $offset): self
    {
        return $this->addMeta(['offset' => $offset]);
    }

    /**
     * @param int $limit
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function setLimit(int $limit): self
    {
        return $this->addMeta(['limit' => $limit]);
    }

    /**
     * @param array $filters
     * @return ResponseBuilder
     * @throws \Exception
     */
    public function setFilters(array $filters): self
    {
        return $this->addMeta(['filters' => $filters]);
    }
}
