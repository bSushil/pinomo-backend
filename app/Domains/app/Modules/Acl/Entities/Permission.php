<?php
namespace Main\Modules\Acl\Entities;

use Core\Entities\AbstractEntity;

/**
 * Permission
 */
class Permission extends AbstractEntity
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
     * $permissionKey
     *
     * @var
     */
    protected $permissionKey;
    /**
     * $entity
     *
     * @var
     */
    protected $entity;
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