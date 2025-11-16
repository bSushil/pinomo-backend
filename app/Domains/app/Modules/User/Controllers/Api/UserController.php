<?php
namespace Main\Modules\User\Controllers\Api;

use Illuminate\Http\Request;
use Core\Controllers\AbstractController;
use Main\Modules\User\Requests\UserRequest;
use Main\Modules\User\Services\UserService;

class UserController extends AbstractController
{
    public function __construct(UserService $service, UserRequest $request)
    {
        $this->domainService = $service;
        $this->domainRequest = $request;
    }
}