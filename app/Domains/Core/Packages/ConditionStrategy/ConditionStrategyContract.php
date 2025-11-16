<?php
namespace Core\Packages\ConditionStrategy;


/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
interface ConditionStrategyContract
{
    /**
     * getMethod.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Get Parameters.
     *
     * @param  string $column.
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array;


}
