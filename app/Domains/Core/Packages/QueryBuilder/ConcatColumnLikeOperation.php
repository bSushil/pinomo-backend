<?php

namespace Core\Packages\QueryBuilder;

use Core\Models\AbstractModel;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class ConcatColumnLikeOperation extends LikeOperation
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'whereRaw';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'concat_column_like';

    /**
     * roles.
     *
     * @var array
     */
    protected $roles = [
        'date_from' => 'required|date',
        'date_to' => 'required|date|after:date_from'
    ];

    /**
     * getData.
     *
     * @param  $data
     * @return array
     */
    public function getData($data): array
    {
        $this->data = [
            'date_from' => trim($data[0]),
            'date_to' => trim(@$data[1])
        ];

        return $this->data;
    }

    /**
     * validate.
     *
     * @param  AbstractModel $model
     * @param  array         $condition
     * @param  array         $columns
     * @param  $value
     * @return mixed|void
     * @throws \Core\Exceptions\ValidationException
     */
    public function validate(AbstractModel $model, array $condition, array $columns, $value)
    {
        $condition = explode('|', $condition[0]);

        foreach ($condition as $columnName){
            parent::validate($model, [$columnName], $columns, $value);
        }
    }

    /**
     * Get Parameters.
     *
     * @param  string $column
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array
    {
        $column = explode('|', $column);

        $argOne = 'concat('.implode(", ' ', ", $column).") like ? ";

        return [$argOne, '%'.$value. '%'];
    }
}
