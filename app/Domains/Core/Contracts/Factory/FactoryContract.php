<?php
namespace Core\Contracts\Factory;

use Core\Contracts\Entity\Entity;

interface FactoryContract
{
    /**
     * create.
     *
     * @param  array $data
     * @return Entity
     */
    public function create(array $data): Entity;

}