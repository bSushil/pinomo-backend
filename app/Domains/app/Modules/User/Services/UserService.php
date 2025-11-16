<?php
namespace Main\Modules\User\Services;

use Core\Services\AbstractService;
use Illuminate\Database\Eloquent\Collection;
use Main\Modules\User\Models\User;
use Main\Modules\User\Repositories\UserRepository;
use Main\Modules\User\Response\UserResponse;
use Main\Modules\User\Validations\UserValidation;

class UserService extends AbstractService
{
    
    /**
     * __construct
     *
     * @param UserValidation $validator
     * @param UserRepository $repository
     * @param UserResponse   $response
     * @param User           $model 
     * 
     * @return void
     */
    public function __construct(
        UserValidation $validator,
        UserRepository $repository,
        UserResponse $response,
        User $model
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->response = $response;
        $this->model = $model;
    }
    
    /**
     * listUsers
     *
     * @return Collection
     */
    public function listAdminUsers(): Collection
    {
        return $this->repository->listAdminUsers();
    }

    public function getUserById(int $id): User
    {
        return $this->repository->getUserById($id);
    }
}