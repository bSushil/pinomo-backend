<?php
namespace Core\Packages\QueryBuilder;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class GreaterEqualOperation extends QueryBuilder
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'where';

    /**
     * operator.
     *
     * @var string
     */
    protected $operator = '>=';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'gte';
}
