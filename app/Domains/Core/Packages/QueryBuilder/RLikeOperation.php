<?php

namespace Core\Packages\QueryBuilder;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class RLikeOperation extends QueryBuilder
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
    protected $name = 'rlike';

    /**
     * Get Parameters.
     *
     * @param  string $column
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array
    {
        return [$column, $this->operator, $value.'%'];
    }
}
