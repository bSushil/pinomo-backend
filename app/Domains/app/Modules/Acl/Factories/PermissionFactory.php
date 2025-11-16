<?php
namespace Main\Modules\Acl\Factories;

use Core\Factories\AbstractFactory;
use Main\Modules\Acl\Entities\Permission;

/**
 * PermissionFactory
 */
class PermissionFactory extends AbstractFactory
{
    
    /**
     * __construct
     *
     * @param  Permission $entity
     * @return void
     */
    public function __construct(Permission $entity)
    {
        $this->entityInstance = $entity;
    }
}