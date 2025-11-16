<?php

namespace Core\Packages\QueryBuilder;

/**
 * AndNotEqualOperation
 *
 * Class AndNotEqualOperation
 *
 * @package Core\Packages\QueryBuilder
 */
class AndNotEqualOperation extends NotEqualOperation
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'where';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'and_not_equal';
}