<?php
namespace Main\Modules\User\Repositories;

use Core\Contracts\Container\Container;
use Core\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Main\Modules\User\Collections\UserCollection;
use Main\Modules\User\Factories\UserFactory;
use Main\Modules\User\Models\User;

class UserRepository extends AbstractRepository
{
    protected $container;
        
    /**
     * __construct
     *
     * @param UserFactory $factory
     * @param UserCollection $collection
     * @param User $model
     * @param Container $container
     */
    /**  
     * @return void
     */
    public function __construct(
        UserFactory $factory,
        UserCollection $collection,
        User $model,
        Container $container
    ) {
        $this->factory = $factory;
        $this->collection = $collection;
        $this->model = $model;
        $this->container = $container;
    }
    
    /**
     * listUsers
     *
     * @return Collection
     */
    public function listAdminUsers(): Collection
    {
        return $this->model->where('role_id', '=', 1)->get();
    }
    
    /**
     * currentUser
     *
     * @return Collection
     */
    public function currentUser(): Collection
    {
        $userID = $this->container->create('auth')->guard()->user()->id;
        $roles = $this->model->with(['roles', 'roles.permissions'])->whereId($userID)->first();

        $roles->permissions = $this->currentUserPermissions();

        $permissionsArr = $this->currentUserPermissions();

        $permissions = [];

        foreach ($permissionsArr as $permission) {
            $permissions = array_merge($permissions, $permission->toArray());
        }

        $roles->permissions = array_map("unserialize", array_unique(array_map("serialize", $permissions)));

        return $roles;
    }
    
    /**
     * currentUserPermissions
     *
     * @return Collection
     */
    public function currentUserPermissions(): Collection
    {
        $userId = $this->container->create('auth')->guard()->user()->id;

        $roles = $this->model->with(['roles', 'roles.permissions'])->whereId($userId)->first()->roles->map(
            function ($role) {

                $permissions = $role->permissions->map(
                    function ($permission) {
                        return [
                        'id' => $permission->id,
                        'entity_name' => last(explode('\\', $permission->entity)),
                        'entity' => $permission->entity,
                        'permission_key' => $permission->permission_key
                        ];
                    }
                );

                return $permissions;
            }
        );

        return $roles;
    }
    
    /**
     * getUserById
     *
     * @param  int $userID
     * @return Model|null
     */
    public function getUserById(int $userID): Model|null
    {
        return $this->model->whereId($userID)->first();
    }
}