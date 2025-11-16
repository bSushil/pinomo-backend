<?php
namespace Core\Contracts\Collection;

use Core\Contracts\Entity\Entity;

interface Collection
{
    /**
     * Add new entity to entity Collection.
     *
     * @param  Entity $entity
     * @return mixed
     */
    public function addEntity(Entity $entity): Collection;

    /**
     * Get All Entities.
     *
     * @return mixed
     */
    public function getEntities(): array;

    /**
     * Get First Entity.
     *
     * @return Entity
     */
    public function getFirstEntity(): Entity;

    /**
     * Set Pagination Attributes.
     *
     * @param  array $data
     * @return mixed
     */
    public function setPaginationAttributes(array $data);

    /**
     * Get Total Items.
     *
     * @return mixed
     */
    public function getTotal(): int;

    /**
     * To Array.
     *
     * @return array
     */
    public function toArray(): array;
}