<?php
namespace Core\Contracts\Authentication;

interface Authentication
{
    public function authenticate(string $role, $throwException = true): bool;

    public function getCorePermissions();

    public function getPermissions();

    public function getEntity();
}