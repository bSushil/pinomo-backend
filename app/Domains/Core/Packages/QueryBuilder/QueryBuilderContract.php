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
interface QueryBuilderContract
{
    /**
     * getMethod.
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Get Operator.
     *
     * @return string
     */
    public function getOperator(): string;

    /**
     * Validate.
     *
     * @param  AbstractModel $model
     * @param  array         $condition
     * @param  array         $columns
     * @param  $value
     * @return mixed
     */
    public function validate(AbstractModel $model, array $condition, array $columns, $value);

    /**
     * Get Parameters.
     *
     * @param  string $column.
     * @param  $value
     * @return array
     */
    public function getParameters(string $column, $value): array;

    /**
     * setData.
     *
     * @param  array $data
     * @return array
     */
    public function data(array $data): array;

    /**
     * Get Roles.
     *
     * @return array
     */
    public function getRoles(): array;
}
