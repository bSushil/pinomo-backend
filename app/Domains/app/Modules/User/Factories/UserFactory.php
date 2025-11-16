<?php
declare(strict_types=1);

namespace Main\Modules\User\Factories;

use Core\Factories\AbstractFactory;
use Main\Modules\User\Entities\User;

class UserFactory extends AbstractFactory
{
    public function __construct(User $order)
    {
        $this->entityInstance = $order;
    }
}