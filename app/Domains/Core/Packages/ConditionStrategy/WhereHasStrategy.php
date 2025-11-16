<?php
namespace Core\Packages\ConditionStrategy;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class WhereHasStrategy extends ConditionStrategy
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'whereHas';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'where_has';

    /**
     * getParameters.
     *
     * @param  string $relation
     * @param  $callback
     * @return array
     */
    public function getParameters(string $relation, $callback): array
    {
        return [$relation, $callback];
    }
}
