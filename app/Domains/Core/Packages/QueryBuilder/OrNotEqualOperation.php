<?php

namespace Core\Packages\QueryBuilder;

/**
 * Or Not Equal Operation
 *
 * Class OrNotEqualOperation
 *
 * @package Core\Packages\QueryBuilder
 */
class OrNotEqualOperation extends NotEqualOperation
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'orWhere';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'or_not_equal';
}