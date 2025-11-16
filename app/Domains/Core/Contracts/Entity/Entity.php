<?php
namespace Core\Contracts\Entity;

interface Entity
{
    /**
     * To Array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Get Properties.
     *
     * @return array
     */
    public function getProperties(): array;
}