<?php
namespace Main\Modules\Acl\Authentication;

use Core\Authentication\AbstractAuthentication;
use Core\Contracts\Container\Container;
use Main\Modules\Acl\Entities\Role;

class RoleAuthentication extends AbstractAuthentication
{
    protected $entity;
    
    public function __construct(Container $container, Role $entity)
    {
        parent::__construct($container);
        $this->entity = $entity;
    }
}