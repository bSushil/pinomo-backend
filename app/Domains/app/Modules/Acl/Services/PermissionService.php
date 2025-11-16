<?php
namespace Main\Modules\Acl\Services;

use Core\Services\AbstractService;
use Main\Modules\Acl\Models\Permission;
use Main\Modules\Acl\Repositories\PermissionRepository;
use Main\Modules\Acl\Response\PermissionResponse;
use Main\Modules\Acl\Validations\PermissionValidation;

/**
 * PermissionService
 */
class PermissionService extends AbstractService
{
    /**
     * __construct
     *
     * @param  PermissionValidation $validator
     * @param  PermissionRepository $repository
     * @param  PermissionResponse   $response
     * @param  Permission           $model
     * @return void
     */
    public function __construct(
        PermissionValidation $validator,
        PermissionRepository $repository,
        PermissionResponse $response,
        Permission $model
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->response = $response;
        $this->model = $model;
    }

    public function getPermissions(): array
    {
        $arPermissionsList = [];

        $permissions = $this->repository->getPermissionsList();

        foreach ($permissions as $permission) {
            preg_match('%^Main\\\\.*\\\\(.*?)$%m', $permission->entity, $matches);
            $entity = $permission->entity;
            if ($matches) {
                $entity = $matches[1];
            }
            $arPermissionsList[$entity][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'permission_key' => $permission->permission_key
            ];
        }

        return $arPermissionsList;
    }
}