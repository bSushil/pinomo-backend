<?php
namespace Main\Modules\Acl\Factories;

use Core\Factories\AbstractFactory;
use Main\Modules\Acl\Entities\Role;

/**
 * RoleFactory
 */
class RoleFactory extends AbstractFactory
{
    
    /**
     * __construct
     *
     * @param  Role $entity
     * @return void
     */
    public function __construct(Role $entity)
    {
        $this->entityInstance = $entity;
    }
}