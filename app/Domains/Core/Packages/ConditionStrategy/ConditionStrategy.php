<?php

namespace Core\Packages\ConditionStrategy;

use Core\ApplicationLayer\Laravel\Models\AbstractModel;
use Core\Exceptions\QueryBuilderItemNotFoundException;
use Core\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class ConditionStrategy implements ConditionStrategyContract
{
    /**
     * method.
     *
     * @var string
     */
    protected $method;


    /**
     * name.
     *
     * @var
     */
    protected $name;

    /**
     * queryBuilderClasses.
     *
     * @var array
     */
    protected $conditionStrategyClasses = [
        'with' => WithStrategy::class,
        'where_has' => WhereHasStrategy::class,
    ];

    /**
     * getMethod.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get Name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * get.
     *
     * @param  string $strategyCondition
     * @return ConditionStrategyContract
     * @throws QueryBuilderItemNotFoundException
     */
    public function get(string $strategyCondition): ConditionStrategyContract
    {
        if (isset($this->conditionStrategyClasses[$strategyCondition]) && class_exists($this->conditionStrategyClasses[$strategyCondition])) {
            return app($this->conditionStrategyClasses[$strategyCondition]);
        }

        throw new QueryBuilderItemNotFoundException('The strategy condition "' . $strategyCondition . '" isn\'t supported');
    }

    /**
     * getParameters.
     *
     * @param  string $relation
     * @param  $callback
     * @return array
     */
    public function getParameters(string $relation, $callback): array
    {
        return [[$relation => $callback]];
    }
}
