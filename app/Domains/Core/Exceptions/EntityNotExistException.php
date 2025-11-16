<?php
/**
 * Core
 *
 * @package   Core.
 * @author    Mohamed Ibrahim <m.ibrahim@integrateddev.com>
 * @version   v.1.0 (06/03/2018)
 * @copyright Copyright (c) 2018 - Integrated Development LCC
 */

namespace Core\Exceptions;

use Throwable;

/**
 * Entity Not Exist Exception
 *
 * Class EntityNotExistException
 *
 * @package App\Domain\Exceptions
 */
class EntityNotExistException extends AbstractException
{
    /**
     * EntityNotExistException constructor.
     *
     * @param array          $errors
     * @param string         $message
     * @param int            $code
     * @param null|Throwable $previous
     */
    public function __construct(string $message = "Entity does not exist", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
