<?php
declare(strict_types=1);

namespace Core\ValueObject;

use Core\Exceptions\ValidationException;

/**
 * Email Address Value object
 *
 * Class EmailAddress
 *
 * @package Core\Services
 */
class EmailAddress extends AbstractValueObject
{
    /**
     * EmailAddress constructor.
     *
     * @param  string $email
     * @throws ValidationException
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('This is not a valid email address');
        }

        $this->value = $email;
    }
}