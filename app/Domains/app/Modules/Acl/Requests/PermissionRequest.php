<?php
namespace Main\Modules\Acl\Requests;

use Core\Request\AbstractRequest;
use Main\Modules\Acl\Entities\Permission;

/**
 * PermissionRequest
 */
class PermissionRequest extends AbstractRequest
{
    
    /**
     * __construct
     *
     * @param  Permission $entity
     * @return void
     */
    public function __construct(Permission $entity)
    {
        $this->entity = $entity;
    }
}