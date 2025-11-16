<?php
declare(strict_types=1);

namespace Core\Collections;

use Core\Contracts\Collection\Collection;
use Core\Contracts\Entity\Entity;

abstract class AbstractCollection implements Collection
{
    /**
     * Total Items.
     *
     * @var
     */
    protected $total = 0;

    /**
     * current_page.
     *
     * @var int
     */
    protected $current_page = 0;

    /**
     * last_page.
     *
     * @var int
     */
    protected $last_page = 0;

    /**
     * per_page.
     *
     * @var int
     */
    protected $per_page = 10;

    /**
     * to.
     *
     * @var
     */
    protected $to;

    /**
     * Entities.
     *
     * @var array
     */
    protected $entities = [];

    /**
     * pagination.
     *
     * @var bool
     */
    protected $pagination = true;

    /**
     * Add new entity to entity Collection.
     *
     * @param  Entity $entity
     * @return mixed
     */
    public function addEntity(Entity $entity): Collection
    {
        $this->entities[] = $entity;
        return $this;
    }

    /**
     * Get First Entity.
     *
     * @return Entity
     */
    public function getFirstEntity(): Entity
    {
        return $this->entities[0];
    }

    /**
     * Get Total Items.
     *
     * @return mixed
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * setTotal.
     *
     * @param $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Set Pagination Attributes.
     *
     * @param  array $data
     * @return mixed|void
     */
    public function setPaginationAttributes(array $data)
    {
        if (!$this->pagination) {
            return false;
        }

        $this->total = $data['total'];
        $this->current_page = $data['current_page'];
        $this->last_page = $data['last_page'];
        $this->per_page = $data['per_page'];
        $this->to = $data['to'];
    }

    /**
     * setPagination.
     *
     * @param $value
     */
    public function setPagination($value)
    {
        $this->pagination = $value;
    }

    /**
     * To Array.
     *
     * @return array.
     */
    public function toArray(): array
    {
        $entities = $this->getEntities();

        $result = get_object_vars($this);

        $result['entities'] = [];

        foreach ($entities as $entity) {
            $result['entities'][] = $entity->toArray();
        }

        return $this->pagination ? $result : $result['entities'];
    }

    /**
     * Get All Entities.
     *
     * @return mixed
     */
    public function getEntities(): array
    {
        return $this->entities;
    }
}