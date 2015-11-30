<?php

namespace Smoovio\Bundle\ApiBundle\Representation;

class Movies implements RepresentationInterface
{
    private $meta;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function addMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMeta($key)
    {
        return $this->meta[$key];
    }
}
