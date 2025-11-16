<?php
namespace Main\Modules\Acl\Repositories;

use Core\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Main\Modules\Acl\Collection\PermissionCollection;
use Main\Modules\Acl\Factories\PermissionFactory;
use Main\Modules\Acl\Models\Permission;

class PermissionRepository extends AbstractRepository
{
    
    /**
     * __construct
     *
     * @param  PermissionFactory    $factory
     * @param  PermissionCollection $collection
     * @param  Permission           $model
     * @return void
     */
    public function __construct(
        PermissionFactory $factory,
        PermissionCollection $collection,
        Permission $model
    ) {
        $this->factory = $factory;
        $this->collection = $collection;
        $this->model = $model;
    }

    public function getPermissionsList(): Collection
    {
        return $this->model
            ->get();
    }
}