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
class URL extends AbstractValueObject
{
    /**
     * String constructor.
     *
     * @param  string $string
     * @throws ValidationException
     */
    public function __construct(string $string)
    {

        //        if (filter_var($string, FILTER_VALIDATE_URL)) {
        //            throw new ValidationException($string. 'must be a valid url');
        //        }

        $this->value = $string;
    }
}