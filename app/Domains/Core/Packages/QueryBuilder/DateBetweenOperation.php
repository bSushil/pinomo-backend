<?php
namespace Core\Packages\QueryBuilder;


use Core\Models\AbstractModel;
use Core\Exceptions\ValidationException;

/**
 * Query Builder Contract
 *
 * Class QueryBuilderContract
 *
 * @package ${NAMESPACE}
 */
class DateBetweenOperation extends QueryBuilder
{
    /**
     * method.
     *
     * @var string
     */
    protected $method = 'whereBetween';

    /**
     * name.
     *
     * @var string
     */
    protected $name = 'date_between';

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
    public function data(array $data): array
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
     * @throws ValidationException
     */
    public function validate(AbstractModel $model, array $condition, array $columns, $value)
    {
        parent::validate($model, $condition, $columns, $value);

        $validation = $this->validator::make($this->data(explode(',', $value)), $this->getRoles());

        if ($validation->fails()) {
            throw new ValidationException($validation->errors()->toArray());
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
        $value = explode(',', $value);

        return [$column, array_values($this->data)];
    }
}
