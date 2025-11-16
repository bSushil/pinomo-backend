<?php
/**
 * Core
 *
 * @package   Core.
 * @author    Mohamed Ibrahim <m.ibrahim@integrateddev.com>
 * @version   v.1.0 (01/05/2018)
 * @copyright Copyright (c) 2018 - Integrated Development LCC
 */

namespace Core\Exceptions;
use Core\Contracts\Exception\ExceptionContract;
use Throwable;

/**
 * Abstraction Exception
 *
 * Class AbstractException
 *
 * @package Core\Contracts\Exception
 */
abstract class AbstractException extends \Exception implements ExceptionContract
{
    /**
     * code.
     *
     * @var int
     */
    protected $code;

    /**
     * AbstractException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 200, Throwable $previous = null)
    {
        $this->code = $code;

        parent::__construct($message, $code, $previous);
    }

    /**
     * getStatusCode.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->code;
    }
}
