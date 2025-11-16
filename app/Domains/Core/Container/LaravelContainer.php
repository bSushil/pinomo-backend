<?php
namespace Core\Container;

class LaravelContainer extends AbstractContainer
{
    public function create($className, $params = [])
    {
        return app($className, $params);
    }
}