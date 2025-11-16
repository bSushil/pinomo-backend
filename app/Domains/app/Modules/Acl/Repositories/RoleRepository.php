<?php
namespace Main\Modules\Acl\Repositories;

use Core\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Main\Modules\Acl\Collection\RoleCollection;
use Main\Modules\Acl\Factories\RoleFactory;
use Main\Modules\Acl\Models\Role;

class RoleRepository extends AbstractRepository
{
    
    /**
     * __construct
     *
     * @param  RoleFactory    $factory
     * @param  RoleCollection $collection
     * @param  Role           $model
     * @return void
     */
    public function __construct(
        RoleFactory $factory,
        RoleCollection $collection,
        Role $model
    ) {
        $this->factory = $factory;
        $this->collection = $collection;
        $this->model = $model;
    }

    public function listRoles(): Collection
    {
        return $this->model->get();
    }
}