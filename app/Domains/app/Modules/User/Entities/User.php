<?php
declare(strict_types=1);

namespace Main\Modules\User\Entities;

use Core\Entities\AbstractEntity;

class User Extends AbstractEntity
{
    /**
     * id
     *
     * @var
     */
    protected $id;
    /**
     * name
     *
     * @var
     */
    protected $name;
    /**
     * email
     *
     * @var
     */
    protected $email;
    /**
     * password
     *
     * @var
     */
    protected $password;
    /**
     * rememberToken
     *
     * @var
     */
    protected $rememberToken;
    /**
     * createdAt
     *
     * @var
     */
    protected $createdAt;
    /**
     * updatedAt
     *
     * @var
     */
    protected $updatedAt;
}