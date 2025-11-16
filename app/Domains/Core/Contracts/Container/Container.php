<?php
namespace Core\Contracts\Container;

interface Container
{
    public function create($className, $params = []);
}