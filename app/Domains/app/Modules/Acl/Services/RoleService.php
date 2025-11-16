<?php
namespace Main\Modules\Acl\Services;

use Core\Contracts\Request\Request;
use Core\Contracts\Response\Response;
use Core\Services\AbstractService;
use Illuminate\Database\Eloquent\Collection;
use Main\Modules\Acl\Models\Role;
use Main\Modules\Acl\Repositories\RoleRepository;
use Main\Modules\Acl\Response\RoleResponse;
use Main\Modules\Acl\Validations\RoleValidation;

/**
 * RoleService
 */
class RoleService extends AbstractService
{
    /**
     * __construct
     *
     * @param  RoleValidation $validator,
     * @param  RoleRepository $repository,
     * @param  RoleResponse   $response,
     * @param  Role           $model
     * @return void
     */
    public function __construct(
        RoleValidation $validator,
        RoleRepository $repository,
        RoleResponse $response,
        Role $model
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->response = $response;
        $this->model = $model;
    }

    public function storeRole(Request $request): Response
    {
        try{
            $this->repository->startTransaction();
            $this->response = parent::store($request);

            $id = $this->response->getData()['id'];
            $this->repository->sync($id, 'permissions', $request->get('permissions', []));

            $this->repository->endTransaction();
        } catch(\Exception $e) {
            $this->repository->rollbackTransaction();
            $this->response->setCode(400);
            $this->response->setData(['error' => $e->getMessage()]);
        }

        return $this->response;
    }

    public function update(Request $request, int $id, $validate=false): Response
    {
        try{
            $this->repository->startTransaction();
            $this->response = parent::update($request, $id, $validate);

            $id = $this->response->getData()['id'];
            $this->repository->sync($id, 'permissions', $request->get('permissions', []));

            $this->repository->endTransaction();
        } catch(\Exception $e) {
            $this->repository->rollbackTransaction();
            $this->response->setCode(400);
            $this->response->setData(['error' => $e->getMessage()]);
        }

        return $this->response;
    }

    public function listRoles(): Collection
    {
        return $this->repository->listRoles();
    }
}