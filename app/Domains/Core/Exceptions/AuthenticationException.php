<?php
/**
 * Core
 *
 * @author    Mohamed Ibrahim <m.ibrahim@integrateddev.com>
 * @version   v.1.0 (06/05/2018)
 * @copyright Copyright (c) 2018 - Integrated Development LCC
 */

namespace Core\Exceptions;

use Throwable;

/**
 * Authentication Failure
 *
 * Class ValidationFailure
 *
 * @package Core\Exceptions
 */
class AuthenticationException extends AbstractException
{
    /**
     * Errors.
     *
     * @var array.
     */
    protected $errors;

    /**
     * AuthenticationException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $message = "Unauthorized", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
