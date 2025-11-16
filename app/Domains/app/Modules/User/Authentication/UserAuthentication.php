<?php
namespace Main\Modules\User\Authentication;

use Core\Authentication\AbstractAuthentication;
use Core\Contracts\Container\Container;
use Main\Modules\User\Entities\User;

class UserAuthentication extends AbstractAuthentication
{
    protected $entity;
    
    public function __construct(Container $container, User $entity)
    {
        parent::__construct($container);
        $this->entity = $entity;
    }
}