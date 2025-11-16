<?php
namespace Main\Modules\SiteDomain\Authentication;

use Core\Authentication\AbstractAuthentication;
use Core\Contracts\Container\Container;
use Main\Modules\SiteDomain\Entities\SiteDomain;

class SiteDomainAuthentication extends AbstractAuthentication
{
    protected $entity;
    
    public function __construct(Container $container, SiteDomain $entity)
    {
        parent::__construct($container);
        $this->entity = $entity;
    }
}