<?php

namespace Core\Packages\QueryBuilder;

/**
 * InOperation
 *
 * Class InOperation
 *
 * @package Core\Packages\QueryBuilder
 */
class InOperation extends QueryBuilder
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'whereIn';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'in';

    /**
     * operator.
     *
     * @var string
     */
    protected $operator = 'whereIn';

    /**
     * getParameters.
     *
     * @param  string $column
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array
    {
        $values = explode(',', $value);

        return [$column,$values];
    }
}
