<?php

namespace Core\Packages\QueryBuilder;


/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class LikeOperation extends QueryBuilder
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
    protected $operator = 'like';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'like';

    /**
     * Get Parameters.
     *
     * @param  string $column
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array
    {
        return [$column, $this->operator, '%'.$value.'%'];
    }
}
