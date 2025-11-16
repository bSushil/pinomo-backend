<?php
namespace Main\Modules\User\Policy;

use Core\Policy\AbstractPolicy;
use Main\Modules\User\Models\User;

class UserPolicy extends AbstractPolicy
{
    public function list(User $user)
    {
        return $user->can('LIST', 'User');
    }

    public function save(User $user)
    {
        return $user->can('SAVE', 'User');
    }

    public function update(User $user)
    {
        return $user->can('UPDATE', 'User');
    }

    public function delete(User $user)
    {
        return $user->can('DELETE', 'User');
    }
}