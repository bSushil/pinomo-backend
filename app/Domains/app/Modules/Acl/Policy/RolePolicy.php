<?php
namespace Main\Modules\Acl\Policy;

use Core\Policy\AbstractPolicy;
use Main\Modules\User\Models\User;

class RolePolicy extends AbstractPolicy
{
    public function list(User $user)
    {
        return $user->can('LIST', 'Role');
    }

    public function save(User $user)
    {
        return $user->can('SAVE', 'Role');
    }

    public function update(User $user)
    {
        return $user->can('UPDATE', 'Role');
    }

    public function delete(User $user)
    {
        return $user->can('DELETE', 'Role');
    }
}