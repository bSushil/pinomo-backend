<?php
namespace Main\Modules\Acl\Entities;

use Core\Entities\AbstractEntity;

/**
 * Role
 */
class Role extends AbstractEntity
{
    /**
     * $id
     *
     * @var
     */
    protected $id;
    /**
     * $name
     *
     * @var
     */
    protected $name;
    /**
     * permissions
     *
     * @collection \Main\Modules\Acl\Collection\PermissionCollection
     * @factory    \Main\Modules\Acl\Factories\PermissionFactory
     */
    protected $permissions;
    /**
     * $deletedAt
     *
     * @var
     */
    protected $deletedAt;
    /**
     * $updatedAt
     *
     * @var
     */
    protected $updatedAt;
    /**
     * $createdAt
     *
     * @var
     */
    protected $createdAt;
}