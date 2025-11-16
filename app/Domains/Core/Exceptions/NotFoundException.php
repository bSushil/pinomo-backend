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
 * Validation Failure
 *
 * Class ValidationFailure
 *
 * @package Core\Exceptions
 */
class NotFoundException extends AbstractException
{
    /**
     * Errors.
     *
     * @var array.
     */
    protected $errors;

    /**
     * NotFoundException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct(string $message = "The requested item not found", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
