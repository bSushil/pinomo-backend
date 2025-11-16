<?php

namespace Core\Packages\QueryBuilder;

/**
 * Class NotInOperation
 *
 * @package Core\Packages\QueryBuilder
 */
class NotInOperation extends QueryBuilder
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'whereNotIn';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'not_in';

    /**
     * operator.
     *
     * @var string
     */
    protected $operator = 'whereNotIn';


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