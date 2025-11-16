<?php
declare(strict_types=1);

namespace Core\ValueObject;

/**
 * Abstract Value Object
 *
 * Class AbstractValueObject
 *
 * @package Core\ValueObject
 */
abstract class AbstractValueObject
{
    /**
     * value.
     *
     * @var
     */
    protected $value;

    /**
     * get.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}