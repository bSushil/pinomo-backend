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
class QueryBuilderItemNotFoundException extends AbstractException
{
    /**
     * Errors.
     *
     * @var array.
     */
    protected $errors;

    /**
     * ValidationException constructor.
     *
     * @param array          $errors
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $message = "The requested query builder item not found", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
