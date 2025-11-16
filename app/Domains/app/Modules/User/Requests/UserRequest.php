<?php
declare(strict_types=1);

namespace Main\Modules\User\Requests;

use Core\Request\AbstractRequest;
use Main\Modules\User\Entities\User;

class UserRequest extends AbstractRequest
{
    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }
}