<?php

namespace Smoovio\Bundle\ApiBundle\Representation;

interface RepresentationInterface
{
    public function getData();
    public function addMeta($key, $value);
} 
