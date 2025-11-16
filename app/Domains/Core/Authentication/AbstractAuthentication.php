<?php
declare(strict_types=1);

namespace Core\Authentication;

use Main\Modules\User\Repositories\UserRepository;
use Main\Modules\Acl\Services\RoleService;
use Main\Modules\User\Services\UserService;
use Core\Contracts\Authentication\Authentication;
use Core\Contracts\Container\Container;
use Core\Contracts\Entity\Entity;
use Core\Exceptions\AuthenticationException;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractAuthentication implements Authentication
{
    /**
     * List Permission.
     */
    const LIST_PERMISSION = 'LIST';

    /**
     * Search Permission.
     */
    const SEARCH_PERMISSION = 'SEARCH';
    /**
     * Save Permission.
     */
    const SAVE_PERMISSION = 'SAVE';

    /**
     * Show Permission.
     */
    const SHOW_PERMISSION = 'SHOW';

    /**
     * Update Permission.
     */
    const UPDATE_PERMISSION = 'UPDATE';

    /**
     * Filter Permission.
     */
    const FILTER_PERMISSION = 'FILTER';

    /**
     * Delete Permission.
     */
    const DELETE_PERMISSION = 'DELETE';


    /**
     * Entity.
     *
     * @var Entity
     */
    protected $entity;
    /**
     * permissions.
     *
     * @var array
     */
    protected $permissions = [];
    /**
     * Permissions.
     *
     * @var array
     */
    private $corePermissions = [
        self::LIST_PERMISSION,
        self::SEARCH_PERMISSION,
        self::SAVE_PERMISSION,
        self::SHOW_PERMISSION,
        self::UPDATE_PERMISSION,
        // self::FILTER_PERMISSION,
        self::DELETE_PERMISSION,
    ];

    /**
     * Role Service.
     *
     * @var RoleService
     */
    protected $userRepository;

    /**
     * container.
     *
     * @var Container
     */
    private $container;

    /**
     * AbstractAuthentication constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->userRepository = $this->container->create(UserRepository::class);
    }

    /**
     * Authenticate.
     *
     * @param string $role
     * @param bool $throwException
     * @return bool
     * @throws AuthenticationException
     */
    public function authenticate(string $role, $throwException = true): bool
    {
        $entityName = $this->getEntity();

        $user = $this->userRepository->currentUser()->toArray();

        // if ($user["status"] === "INACTIVE") {
        //     return false;
        // }

        $userPermissions = $this->userRepository->currentUserPermissions()->toArray();

        foreach ($userPermissions as $userPermission) {
            foreach ($userPermission as $permission) {
                if ($permission['entity'] === $entityName && $permission['permission_key'] === $role) {
                    return true;
                }
            }
        }

        if ($throwException) {
            throw new AuthenticationException(last(explode('\\',$entityName)).'|'. $role );
        }

        return false;
    }

    /**
     * authenticateWithoutException.
     *
     * @param string $role
     * @return bool
     * @throws AuthenticationException
     */
    public function authenticateWithoutException(string $role): bool
    {
        return $this->authenticate($role, false);
    }

    /**
     * authenticateOwnership.
     * @param Entity $entity
     * @return bool
     * @throws AuthenticationException
     */
    // public function authenticateOwnership(Entity $entity): bool
    // {
    //     $user = $this->userRepository->currentUser();

    //     if (!isset($entity->toArray()["created_by"])) {
    //         return true;
    //     }

    //     $createdBy = $entity->toArray()["created_by"];

    //     if ($user->id == $createdBy["id"]) {
    //         return true;
    //     }

    //     $entityName = $this->getEntity();

    //     throw new AuthenticationException(last(explode('\\',$entityName)).'|'. "MANAGE_MINE" );
    // }

    /**
     * getCorePermissions.
     * @return array
     */
    public function getCorePermissions(): array
    {
        return $this->corePermissions;
    }

    /**
     * getCorePermissions.
     * @return array
     */
    public function setCorePermissions($permissions)
    {
        return $this->corePermissions = $permissions;
    }

    /**
     * Get Permissions.
     *
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * getEntity.
     * @return string
     */
    public function getEntity(): string
    {
        return get_class($this->entity);
    }
    
    /**
     * getCurrentUser
     *
     * @return void
     */
    public function getCurrentUser() : Model
    {
        return $this->userRepository->currentUser();
    }

}