<?php
namespace Main\Modules\Acl\Requests;

use Core\Request\AbstractRequest;
use Main\Modules\Acl\Entities\Role;

/**
 * RoleRequest
 */
class RoleRequest extends AbstractRequest
{
    
    /**
     * __construct
     *
     * @param  Role $entity
     * @return void
     */
    public function __construct(Role $entity)
    {
        $this->entity = $entity;
    }
}